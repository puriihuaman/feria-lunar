<article class="card">
  <div class="thumbnail">
    <picture>
      <source 
        srcset="{{ asset( 'assets/image/' . $image) }}, {{ asset('assets/image/feria_lunar_stand.jpg') }}"
        loading="lazy"
        />
      <img 
        src="{{ asset('assets/image/feria_lunar_stand.jpg') }}" 
        alt="{{ $title }} - {{ $address }}"
        loading="lazy"
        class="image"
      />
    </picture>
    {{-- <img src="{{ asset($image) }}" alt="{{ $title . ' - ' . $address }}" class="image"/> --}}
  </div>

  <div class="content">
    <h3 class="title">{{ $title }}</h3>
    <p>
      {{ $address }}
      <span class="reference">Ref: {{ $reference }}</span>
    </p>
    <p class="capacity">
      Capacidad: {{ $capacity }} {{ $capacity > 1 ? 'stand(s)' : 'stand' }}
    </p>
  </div>

  <footer class="card__footer">
    <a href="{{ $link }}" class="link">Visitar sede</a>
  </footer>
</article>
