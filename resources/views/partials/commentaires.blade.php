
@if(!Auth::user()->hasRole("Admin"))
            @if(!$commentaire)
            <section>
                <h2>Ajouter une note</h2>
                <form action="{{ $route_store }}" method="post" id="comment">
                    @csrf
                    <div class="form-input-container">
                        <label for="comment"></label>
                        <input type="text" id="body" name="comment" placeholder="NOTE">
                        @error('comment')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-button">
                        <button type="submit" class="btn-submit">ajouter</button>
                    </div>
                </form>
            </section>
            @else
            <section>
                <h2>Note</h2>
                @if(session()->has('successMessage'))
                    <div>
                        {{ session('successMessage') }}
                    </div>
                @endif
                <div class="form-container">
                    <form action="{{ $route_update }}" method="post" id="comment">
                        @csrf
                        @method('put')
                        <div class="form-input-container">
                            <label for="comment"></label>
                            <input type="text" id="body" name="comment" value="{{ $commentaire->corps }}">
                            @error('comment')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <p><span>Ajouté le: </span>{{ $commentaire->updated_at->setTimezone('America/Toronto') }}</p>
                        </div>
                        <div class="form-button">
                            <button type="submit" class="btn-submit">modifier</button>
                        </div>
                    </form> 
                </div>
                <form action="{{ $route_delete }}" method="post" id="supprimerCommentaire">
                    @method('delete')
                    @csrf
                    <div class="form-button">
                        <button type="submit" form="supprimerCommentaire" class="link btn-supprimer">supprimer</button>
                    </div>
                </form>
            </section>
            <!-- Modale suppression -->
            <dialog id="modal-supprimer" class="modal">
                <h2>Suppression de la note</h2>
                <hr>
                <p>Êtes-vous certain de vouloir supprimer la note?</p>
                <form action="{{ $route_delete }}" method="post" class="form-modal" id="supprimerCommentaire">
                    @csrf
                    @method('DELETE')
                    <div class="btn-modal-container">
                        <button type="submit" form="supprimerCommentaire" class="btn-modal-action btn-red">oui, supprimer</button>
                        <button class="btn-modal-cancel btn-green">annuler</button>
                    </div>
                </form>
            </dialog>
            @endif
            @endif