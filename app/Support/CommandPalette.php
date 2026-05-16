<?php

namespace App\Support;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Module as ModuleInstance;

class CommandPalette
{
    /** @var list<string> */
    private const SKIP_ROUTE_SUFFIXES = ['data'];

    /**
     * @return list<array{id: string, label: string, url: string, group: string, keywords: list<string>}>
     */
    public static function items(): array
    {
        $items = [
            self::item(
                id: 'home',
                label: 'Home',
                url: url('/'),
                group: 'Navigation',
                keywords: ['welcome', 'dashboard', 'life', 'os'],
            ),
        ];

        foreach (Module::allEnabled() as $module) {
            $items = array_merge($items, self::moduleItems($module));
        }

        usort($items, function (array $a, array $b): int {
            if ($a['id'] === 'home') {
                return -1;
            }
            if ($b['id'] === 'home') {
                return 1;
            }

            $group = strcasecmp($a['group'], $b['group']);
            if ($group !== 0) {
                return $group;
            }

            return strcasecmp($a['label'], $b['label']);
        });

        return $items;
    }

    /**
     * @return list<array{id: string, label: string, url: string, group: string, keywords: list<string>}>
     */
    private static function moduleItems(ModuleInstance $module): array
    {
        $alias = $module->getLowerName();
        $group = $module->getName();
        $items = [];

        foreach (Route::getRoutes() as $route) {
            $name = $route->getName();

            if ($name === null || ! str_starts_with($name, "{$alias}.")) {
                continue;
            }

            if (! in_array('GET', $route->methods(), true)) {
                continue;
            }

            if ($route->parameterNames() !== []) {
                continue;
            }

            $suffix = Str::after($name, "{$alias}.");

            if (in_array($suffix, self::SKIP_ROUTE_SUFFIXES, true)) {
                continue;
            }

            $items[] = self::item(
                id: $name,
                label: self::labelForRoute($group, $suffix),
                url: route($name),
                group: $group,
                keywords: [$alias, $suffix, Str::lower($group)],
            );
        }

        return $items;
    }

    private static function labelForRoute(string $moduleName, string $suffix): string
    {
        return match ($suffix) {
            'index' => $moduleName,
            'create' => 'New '.Str::singular(Str::lower($moduleName)),
            default => Str::headline($suffix),
        };
    }

    /**
     * @param  list<string>  $keywords
     * @return array{id: string, label: string, url: string, group: string, keywords: list<string>}
     */
    private static function item(string $id, string $label, string $url, string $group, array $keywords = []): array
    {
        return compact('id', 'label', 'url', 'group', 'keywords');
    }
}
