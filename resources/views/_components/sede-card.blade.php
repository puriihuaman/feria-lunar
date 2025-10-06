<article class="card">
  <div class="thumbnail">
    <img src="{{ asset($image) }}" alt="{{ $title . ' - ' . $address }}" class="image"/>
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
