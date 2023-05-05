@props(['disabled' => false])
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => ' text-red-600 border-y-cyan-600 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm pb-3']) !!}>
