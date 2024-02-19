<button {{ $attributes->merge([ 'type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-main border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700  transition ease-in-out duration-150 text-center px-10 py-2' ]) }}>
    {{ $slot }}
</button>
