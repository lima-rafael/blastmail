<div>
    <x-input.richtext class="block mt-1 w-full" name="body" :value="old('body', $data['body'])" autofocus />
    <x-input-error :messages="$errors->get('body')" class="mt-2" />
</div>
