@props(['field'])

@error($field)
<p class="invalid-feedback">{{ $message }}</p>
@enderror
