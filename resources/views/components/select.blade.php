<select {{ $attributes->class('
    w-full appearance-none border-gray-300 bg-gray-900 rounded-md px-4 py-[10px] text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:border-gray-700 dark:bg-gray-900 dark:focus:ring-indigo-600 mt-1'
)}}>
    {{ $slot }}
</select>