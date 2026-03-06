<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="md:col-span-2">
        <x-input-label for="name" value="Product/Service Name" class="mb-2" />
        <x-text-input id="name" name="name" class="block mt-1 w-full" type="text" placeholder="e.g. House Blend Robusta / Jasa Roasting Light" :value="old('name', $product->name ?? '')" required />
    </div>
    
    <div>
        <x-input-label for="service_type" value="Roastery Service Type" class="mb-2" />
        <select id="service_type" name="service_type" class="block w-full border-gray-300 focus:border-coffee-500 focus:ring-coffee-500 rounded-md shadow-sm">
            <option value="biji_sangrai" {{ old('service_type', $product->service_type ?? '') == 'biji_sangrai' ? 'selected' : '' }}>Jual Biji Sangrai (Roasted Beans)</option>
            <option value="kopi_bubuk" {{ old('service_type', $product->service_type ?? '') == 'kopi_bubuk' ? 'selected' : '' }}>Jual Kopi Bubuk (Ground)</option>
            <option value="jasa_roasting" {{ old('service_type', $product->service_type ?? '') == 'jasa_roasting' ? 'selected' : '' }}>Jasa Roasting (Maklon)</option>
        </select>
    </div>

    <div>
        <x-input-label for="roast_level" value="Roast Level" class="mb-2" />
        <select id="roast_level" name="roast_level" class="block w-full border-gray-300 focus:border-coffee-500 focus:ring-coffee-500 rounded-md shadow-sm">
            <option value="light" {{ old('roast_level', $product->roast_level ?? '') == 'light' ? 'selected' : '' }}>Light Roast</option>
            <option value="medium" {{ old('roast_level', $product->roast_level ?? '') == 'medium' ? 'selected' : '' }}>Medium Roast</option>
            <option value="medium_dark" {{ old('roast_level', $product->roast_level ?? '') == 'medium_dark' ? 'selected' : '' }}>Medium Dark</option>
            <option value="dark" {{ old('roast_level', $product->roast_level ?? '') == 'dark' ? 'selected' : '' }}>Dark Roast</option>
        </select>
    </div>

    <div class="md:col-span-2 bg-yellow-50 p-4 border rounded-md">
        <p class="text-xs text-yellow-800 font-bold mb-2">Isi jika berjualan Kopi Bubuk / Biji Sangrai Fisik:</p>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="variety" value="Variety" class="mb-1 text-xs" />
                <x-text-input id="variety" name="variety" class="block w-full" type="text" placeholder="Robusta..." :value="old('variety', $product->variety ?? '')" />
            </div>
            <div>
                <x-input-label for="origin" value="Origin" class="mb-1 text-xs" />
                <x-text-input id="origin" name="origin" class="block w-full" type="text" placeholder="Temanggung..." :value="old('origin', $product->origin ?? '')" />
            </div>
            <div>
                <x-input-label for="process" value="Process" class="mb-1 text-xs" />
                <select id="process" name="process" class="block w-full border-gray-300 focus:border-coffee-500 focus:ring-coffee-500 rounded-md shadow-sm py-2">
                    <option value="">-- Pilih --</option>
                    <option value="natural" {{ old('process', $product->process ?? '') == 'natural' ? 'selected' : '' }}>Natural</option>
                    <option value="washed" {{ old('process', $product->process ?? '') == 'washed' ? 'selected' : '' }}>Washed / Full Wash</option>
                    <option value="honey" {{ old('process', $product->process ?? '') == 'honey' ? 'selected' : '' }}>Honey</option>
                    <option value="anaerobic" {{ old('process', $product->process ?? '') == 'anaerobic' ? 'selected' : '' }}>Anaerobic</option>
                    <option value="wet_hulled" {{ old('process', $product->process ?? '') == 'wet_hulled' ? 'selected' : '' }}>Giling Basah</option>
                </select>
            </div>
            <div>
                <x-input-label for="weight_gram" value="Weight (gram)" class="mb-1 text-xs" />
                <x-text-input id="weight_gram" name="weight_gram" class="block w-full" type="number" placeholder="250" :value="old('weight_gram', $product->weight_gram ?? '')" />
            </div>
        </div>
    </div>

    <div class="md:col-span-2 bg-blue-50 p-4 border border-blue-100 rounded-md">
        <p class="text-xs text-blue-800 font-bold mb-2">Isi jika menawarkan Jasa Roasting (Maklon):</p>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="min_order_kg" value="Min Order (Kg)" class="mb-1 text-xs" />
                <x-text-input id="min_order_kg" name="min_order_kg" class="block w-full" type="number" step="0.1" placeholder="5" :value="old('min_order_kg', $product->min_order_kg ?? '')" />
            </div>
            <div>
                <x-input-label for="price_per_kg" value="Price per Kg (Rp)" class="mb-1 text-xs" />
                <x-text-input id="price_per_kg" name="price_per_kg" class="block w-full" type="number" placeholder="20000" :value="old('price_per_kg', $product->price_per_kg ?? '')" />
            </div>
        </div>
    </div>

    <div>
        <x-input-label for="price" value="Total Price (Biji Kemasan) (Rp)" class="mb-2" />
        <x-text-input id="price" name="price" class="block mt-1 w-full" type="number" placeholder="85000" :value="old('price', $product->price ?? '')" required />
    </div>
    
    <div>
        <x-input-label for="stock" value="Stock Packs (Isi 0 jika jasa)" class="mb-2" />
        <x-text-input id="stock" name="stock" class="block mt-1 w-full" type="number" :value="old('stock', $product->stock ?? 0)" required />
    </div>

    <div class="md:col-span-2">
        <x-input-label for="photo" value="Service/Product Photo" class="mb-2" />
        <input type="file" id="photo" name="photo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-coffee-50 file:text-coffee-700 hover:file:bg-coffee-100" />
        <p class="mt-1 text-xs text-gray-400">Accepted formats: JPG, PNG, WebP (Max 2MB)</p>
    </div>

    <div class="md:col-span-2">
        <x-input-label for="description" value="Description" class="mb-2" />
        <textarea id="description" name="description" rows="3" class="block w-full border-gray-300 focus:border-coffee-500 focus:ring-coffee-500 rounded-md shadow-sm" placeholder="Notes, rules roasting, etc..." required>{{ old('description', $product->description ?? '') }}</textarea>
    </div>
</div>
