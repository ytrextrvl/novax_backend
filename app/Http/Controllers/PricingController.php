<?php

namespace App\Http\Controllers;

use App\Models\PricingRule;
use Illuminate\Http\Request;

class PricingController extends Controller
{
    public function rules()
    {
        return response()->json([
            'rules' => PricingRule::query()->orderBy('priority')->get()
        ]);
    }

    public function createRule(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'priority' => ['nullable','integer','min:0'],
            'conditions' => ['required','array'],
            'actions' => ['required','array'],
            'enabled' => ['nullable','boolean'],
        ]);

        $rule = PricingRule::create([
            'name' => $data['name'],
            'priority' => $data['priority'] ?? 100,
            'conditions' => $data['conditions'],
            'actions' => $data['actions'],
            'enabled' => $data['enabled'] ?? true,
        ]);

        activity()->causedBy(auth('api')->user())->performedOn($rule)->log('pricing.rule_create');

        return response()->json(['rule' => $rule], 201);
    }

    public function apply(Request $request)
    {
        $data = $request->validate([
            'base_price' => ['required','numeric','min:0'],
            'context' => ['required','array'],
        ]);

        $price = (float)$data['base_price'];

        $rules = PricingRule::query()->where('enabled', true)->orderBy('priority')->get();

        foreach ($rules as $rule) {
            if ($this->matches($rule->conditions ?? [], $data['context'])) {
                $price = $this->applyActions($price, $rule->actions ?? []);
            }
        }

        return response()->json([
            'base_price' => (float)$data['base_price'],
            'final_price' => round($price, 2),
        ]);
    }

    private function matches(array $conditions, array $context): bool
    {
        // Simple matcher:
        // conditions: [{field:"from", op:"eq", value:"ADE"}]
        foreach ($conditions as $c) {
            $field = $c['field'] ?? null;
            $op = $c['op'] ?? 'eq';
            $value = $c['value'] ?? null;
            $actual = data_get($context, $field);

            if ($field === null) return false;

            $ok = match ($op) {
                'eq' => (string)$actual === (string)$value,
                'neq' => (string)$actual !== (string)$value,
                'in' => is_array($value) ? in_array($actual, $value, true) : false,
                'contains' => is_string($actual) && is_string($value) ? str_contains($actual, $value) : false,
                default => false,
            };

            if (! $ok) return false;
        }
        return true;
    }

    private function applyActions(float $price, array $actions): float
    {
        // actions: [{type:"percent_markup", value:10}, {type:"fixed_add", value:5}]
        foreach ($actions as $a) {
            $type = $a['type'] ?? null;
            $value = (float)($a['value'] ?? 0);

            if ($type === 'percent_markup') {
                $price *= (1 + ($value / 100));
            } elseif ($type === 'percent_discount') {
                $price *= (1 - ($value / 100));
            } elseif ($type === 'fixed_add') {
                $price += $value;
            } elseif ($type === 'fixed_sub') {
                $price -= $value;
            }
        }
        return max($price, 0.0);
    }
}
