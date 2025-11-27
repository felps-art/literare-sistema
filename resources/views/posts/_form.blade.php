@csrf
<div class="mb-3">
    <label class="form-label fw-semibold">Conteúdo *</label>
    <textarea name="content" rows="4" class="form-control" required>{{ old('content', $post->content ?? '') }}</textarea>
    @error('content')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    <div class="form-text">Máximo 5000 caracteres.</div>
</div>
<div class="mb-3">
    <label class="form-label fw-semibold">Fotos (opcional)</label>
    <input type="file" name="photos[]" multiple accept="image/*" class="form-control" id="post-photos-input">
    @error('photos.*')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
    <div id="new-photos-preview" class="row g-2 mt-2" style="display:none;"></div>
    @if(isset($post) && $post->photos->count())
        <div class="row g-2 mt-2">
            @foreach($post->photos as $photo)
                <div class="col-6 col-md-4 col-lg-3">
                    <img src="{{ $photo->url }}" class="img-fluid rounded" style="height:120px;object-fit:cover;width:100%;" alt="Foto do post">
                </div>
            @endforeach
        </div>
    @endif
    <div class="form-text">Cada imagem até 4MB. Formatos: jpeg, png, jpg, gif, webp.</div>
</div>
<div class="d-flex gap-2 mt-3">
    <button class="btn btn-primary"><i class="fas fa-save me-1"></i>Salvar</button>
    <a href="{{ isset($post) ? route('posts.show',$post) : route('posts.index') }}" class="btn btn-outline-secondary">Cancelar</a>
</div>
@push('scripts')
<script>
// Pré-visualização das novas imagens selecionadas
(function(){
  const input = document.getElementById('post-photos-input');
  const previewRow = document.getElementById('new-photos-preview');
  if(!input || !previewRow) return;
  input.addEventListener('change', function(){
     previewRow.innerHTML='';
     const files = Array.from(this.files || []);
     if(!files.length){ previewRow.style.display='none'; return; }
     files.forEach(f => {
        const col = document.createElement('div');
        col.className='col-6 col-md-4 col-lg-3';
        const img = document.createElement('img');
        img.className='img-fluid rounded';
        img.style.height='120px';
        img.style.objectFit='cover';
        img.style.width='100%';
        img.alt='Pré-visualização';
        img.src = URL.createObjectURL(f);
        col.appendChild(img);
        previewRow.appendChild(col);
     });
     previewRow.style.display='flex';
  });
})();
</script>
@endpush
