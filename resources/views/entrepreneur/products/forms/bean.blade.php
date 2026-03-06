<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="md:col-span-2">
        <x-input-label for="name" value="Bean Product Name" class="mb-2" />
        <x-text-input id="name" name="name" class="block mt-1 w-full" type="text" placeholder="e.g. Arabica Sumbing Specialty" :value="old('name', $product->name ?? '')" required />
    </div>
    
    <div>
        <x-input-label for="bean_status" value="Bean Status/Condition" class="mb-2" />
        <select id="bean_status" name="bean_status" class="block w-full border-gray-300 focus:border-coffee-500 focus:ring-coffee-500 rounded-md shadow-sm">
            <option value="roasted_bean" {{ old('bean_status', $product->bean_status ?? '') == 'roasted_bean' ? 'selected' : '' }}>Roasted Bean (Biji Sangrai)</option>
            <option value="green_bean" {{ old('bean_status', $product->bean_status ?? '') == 'green_bean' ? 'selected' : '' }}>Green Bean (Biji Mentah)</option>
            <option value="ground" {{ old('bean_status', $product->bean_status ?? '') == 'ground' ? 'selected' : '' }}>Ground (Kopi Bubuk)</option>
        </select>
    </div>

    <div>
        <x-input-label for="variety" value="Coffee Variety" class="mb-2" />
        <x-text-input id="variety" name="variety" class="block mt-1 w-full" type="text" placeholder="Arabica/Robusta/Liberica/Excelsa" :value="old('variety', $product->variety ?? '')" required />
    </div>
    
    <div>
        <x-input-label for="origin" value="Origin / Kecamatan" class="mb-2" />
        <x-text-input id="origin" name="origin" class="block mt-1 w-full" type="text" placeholder="Sindoro / Sumbing / Tretep" :value="old('origin', $product->origin ?? '')" required />
    </div>

    <div>
        <x-input-label for="altitude_masl" value="Altitude (MASL) - Optional" class="mb-2" />
        <x-text-input id="altitude_masl" name="altitude_masl" class="block mt-1 w-full" type="number" placeholder="1400" :value="old('altitude_masl', $product->altitude_masl ?? '')" />
    </div>

    <div>
        <x-input-label for="process" value="Post-Harvest Process" class="mb-2" />
        <select id="process" name="process" class="block w-full border-gray-300 focus:border-coffee-500 focus:ring-coffee-500 rounded-md shadow-sm">
            <option value="natural" {{ old('process', $product->process ?? '') == 'natural' ? 'selected' : '' }}>Natural</option>
            <option value="washed" {{ old('process', $product->process ?? '') == 'washed' ? 'selected' : '' }}>Washed / Full Wash</option>
            <option value="honey" {{ old('process', $product->process ?? '') == 'honey' ? 'selected' : '' }}>Honey Process</option>
            <option value="anaerobic" {{ old('process', $product->process ?? '') == 'anaerobic' ? 'selected' : '' }}>Anaerobic</option>
            <option value="wet_hulled" {{ old('process', $product->process ?? '') == 'wet_hulled' ? 'selected' : '' }}>Wet Hulled (Giling Basah)</option>
        </select>
    </div>

    <div>
        <x-input-label for="weight_gram" value="Net Weight (Gram)" class="mb-2" />
        <x-text-input id="weight_gram" name="weight_gram" class="block mt-1 w-full" type="number" placeholder="250" :value="old('weight_gram', $product->weight_gram ?? '')" required />
    </div>

    <div class="border-t pt-4">
        <x-input-label for="roast_level" value="Roast Level (Kosongkan jika Green Bean)" class="mb-2 text-xs font-bold text-gray-500" />
        <select id="roast_level" name="roast_level" class="block w-full border-gray-300 focus:border-coffee-500 focus:ring-coffee-500 rounded-md shadow-sm text-sm">
            <option value="light" {{ old('roast_level', $product->roast_level ?? '') == 'light' ? 'selected' : '' }}>Light Roast</option>
            <option value="medium" {{ old('roast_level', $product->roast_level ?? '') == 'medium' ? 'selected' : '' }}>Medium Roast</option>
            <option value="medium_dark" {{ old('roast_level', $product->roast_level ?? '') == 'medium_dark' ? 'selected' : '' }}>Medium Dark</option>
            <option value="dark" {{ old('roast_level', $product->roast_level ?? '') == 'dark' ? 'selected' : '' }}>Dark Roast</option>
        </select>
    </div>

    <div class="border-t pt-4">
        <x-input-label for="grind_size" value="Grind Size (Kosongkan jika bukan Bubuk)" class="mb-2 text-xs font-bold text-gray-500" />
        <select id="grind_size" name="grind_size" class="block w-full border-gray-300 focus:border-coffee-500 focus:ring-coffee-500 rounded-md shadow-sm text-sm">
            <option value="fine" {{ old('grind_size', $product->grind_size ?? '') == 'fine' ? 'selected' : '' }}>Fine (Espresso/Tubruk)</option>
            <option value="medium" {{ old('grind_size', $product->grind_size ?? '') == 'medium' ? 'selected' : '' }}>Medium (V60/Pour Over)</option>
            <option value="coarse" {{ old('grind_size', $product->grind_size ?? '') == 'coarse' ? 'selected' : '' }}>Coarse (French Press)</option>
            <option value="extra_fine" {{ old('grind_size', $product->grind_size ?? '') == 'extra_fine' ? 'selected' : '' }}>Extra Fine (Turkish)</option>
        </select>
    </div>

    <div>
        <x-input-label for="price" value="Price per Pack (Rp)" class="mb-2" />
        <x-text-input id="price" name="price" class="block mt-1 w-full" type="number" placeholder="85000" :value="old('price', $product->price ?? '')" required />
    </div>
    
    <div>
        <x-input-label for="stock" value="Stock Packs Available" class="mb-2" />
        <x-text-input id="stock" name="stock" class="block mt-1 w-full" type="number" placeholder="50" :value="old('stock', $product->stock ?? '')" required />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="photo" value="Product Photo" class="mb-2" />
        <input type="file" id="photo" name="photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-coffee-50 file:text-coffee-700 hover:file:bg-coffee-100" />
        <p class="mt-1 text-xs text-gray-400">Accepted formats: JPG, PNG, WebP (Max 2MB)</p>
    </div>

    <div class="md:col-span-2">
        <x-input-label for="description" value="Description / Tasting Notes" class="mb-2" />
        <textarea id="description" name="description" rows="4" class="block w-full border-gray-300 focus:border-coffee-500 focus:ring-coffee-500 rounded-md shadow-sm" placeholder="Notes: Brown Sugar, Chocolate..." required>{{ old('description', $product->description ?? '') }}</textarea>
    </div>
</div>
