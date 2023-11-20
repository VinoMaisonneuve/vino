@if(isset($results))
    @if($results->isEmpty())
        <p>Aucun résultat trouvé.</p>
    @else
        <div class="card-count">
            <p>{{$results->total()}} bouteilles :</p>
        </div>
        @foreach ($results as $result)
        <section class="card-bouteille">
            <picture>
                <img src="{{ $result->srcImage }}" alt="{{ $result->nom }}">
            </picture>
            <div class="card-bouteille-content">
                <div class="card-bouteille-info">
                    <h2><a href="{{ route('bouteille.show',['bouteille_id'=> $result->id]) }}">{{ $result->nom }}</a></h2>
                    <span>{{ $result->type }} | {{ $result->format }} | {{ $result->pays }}</span>
                    <p>{{ $result->prix }} $</p>
                </div>
                @if(!Auth::user()->hasRole("Admin"))
                <a href="#" class="btn-ajouter" data-bouteille-id="{{ $result->id }}">+ Ajouter</a>
                @endif
            </div>
        </section>
        @endforeach
        <div id="pagination">
            {{ $results->appends(request()->query())->links() }}
        </div>
    @endif
@endif
