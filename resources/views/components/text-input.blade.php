@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border border-slate-200 rounded-xl px-4 py-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:border-indigo-400 transition-colors w-full bg-white disabled:bg-slate-50 disabled:text-slate-400']) }}>
