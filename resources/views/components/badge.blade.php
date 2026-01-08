@props([
    'danger' => null,
    'warning' => null,
])

<span
    {{$attributes->class
    ([
        "rounded-xl w-fit border px-2 py-1 text-xs font-medium",
        "border-red-500 bg-red-500 text-on-danger dark:border-danger dark:bg-danger dark:text-on-danger" => $danger,
        "border-warning-500 bg-warning-500 text-on-warning dark:border-warning dark:bg-warning dark:text-on-warning" => $warning,
    ])
}}>
    {{ $slot }}
</span>