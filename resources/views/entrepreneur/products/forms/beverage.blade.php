<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="md:col-span-2">
        <x-input-label for="name" value="Drink Name" class="mb-2" />
        <x-text-input id="name" name="name" class="block mt-1 w-full" type="text" placeholder="e.g. Avocado Coffee Frappe" :value="old('name', $product->name ?? '')" required />
    </div>
    
    <div>
        <x-input-label for="drink_type" value="Drink Base/Type" class="mb-2" />
        <select id="drink_type" name="drink_type" class="block w-full border-gray-300 focus:border-coffee-500 focus:ring-coffee-500 rounded-md shadow-sm">
            <option value="espresso_based" {{ old('drink_type', $product->drink_type ?? '') == 'espresso_based' ? 'selected' : '' }}>Espresso Based</option>
            <option value="manual_brew" {{ old('drink_type', $product->drink_type ?? '') == 'manual_brew' ? 'selected' : '' }}>Manual Brew</option>
            <option value="non_coffee" {{ old('drink_type', $product->drink_type ?? '') == 'non_coffee' ? 'selected' : '' }}>Non-Coffee</option>
            <option value="signature" {{ old('drink_type', $product->drink_type ?? '') == 'signature' ? 'selected' : '' }}>Signature Blend</option>
        </select>
    </div>
    
    <div>
        <x-input-label for="temperature" value="Temperature" class="mb-2" />
        <select id="temperature" name="temperature" class="block w-full border-gray-300 focus:border-coffee-500 focus:ring-coffee-500 rounded-md shadow-sm">
            <option value="hot" {{ old('temperature', $product->temperature ?? '') == 'hot' ? 'selected' : '' }}>Hot</option>
            <option value="iced" {{ old('temperature', $product->temperature ?? '') == 'iced' ? 'selected' : '' }}>Iced</option>
            <option value="blended" {{ old('temperature', $product->temperature ?? '') == 'blended' ? 'selected' : '' }}>Blended / Frappe</option>
            <option value="all" {{ old('temperature', $product->temperature ?? '') == 'all' ? 'selected' : '' }}>Hot & Iced (All)</option>
        </select>
    </div>

    <div>
        <x-input-label for="price" value="Base Price (Rp)" class="mb-2" />
        <x-text-input id="price" name="price" class="block mt-1 w-full" type="number" placeholder="25000" :value="old('price', $product->price ?? '')" required />
    </div>
    
    <div>
        <x-input-label for="stock" value="Stock/Availability Count" class="mb-2" />
        <x-text-input id="stock" name="stock" class="block mt-1 w-full" type="number" placeholder="50" :value="old('stock', $product->stock ?? '')" required />
    </div>

    <div>
        <x-input-label for="size_options" value="Size Options (Optional)" class="mb-2" />
        <x-text-input id="size_options" name="size_options" class="block mt-1 w-full" type="text" placeholder="e.g. Regular / Large" :value="old('size_options', $product->size_options ?? '')" />
    </div>
    
    <div class="flex items-center mt-8">
        <input id="is_customizable" type="checkbox" name="is_customizable" value="1" {{ old('is_customizable', $product->is_customizable ?? false) ? 'checked' : '' }} class="w-4 h-4 text-coffee-600 bg-gray-100 border-gray-300 rounded focus:ring-coffee-500 focus:ring-2">
        <label for="is_customizable" class="ml-2 text-sm font-medium text-gray-900">Customizable (Less Sugar, Extra Shot)</label>
    </div>

    <div class="md:col-span-2">
        <x-input-label for="photo" value="Drink Photo" class="mb-2" />
        <input type="file" id="photo" name="photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-coffee-50 file:text-coffee-700 hover:file:bg-coffee-100" />
        <p class="mt-1 text-xs text-gray-400">Accepted formats: JPG, PNG, WebP (Max 2MB)</p>
    </div>

    <div class="md:col-span-2">
        <x-input-label for="description" value="Drink Description" class="mb-2" />
        <textarea id="description" name="description" rows="3" class="block w-full border-gray-300 focus:border-coffee-500 focus:ring-coffee-500 rounded-md shadow-sm" placeholder="Explain the ingredients and notes..." required>{{ old('description', $product->description ?? '') }}</textarea>
    </div>
</div>
