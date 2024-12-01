<input id="{{ $id ?? $name }}" type="{{ $type ?? 'text' }}" name="{{ $name }}" value="{{ old($name, $value ?? '') }}"
    {{ $attributes->merge(['class' => 'block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) }}
/>
