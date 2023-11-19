<table class="admin-table">
    <thead>
        <tr>
            <th>IDENTIFIANT</th>    
            <th>NOM</th>
            <th>RÔLE</th>
            <th>ACTION</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
        <tr class="user-row">
            <td class="user-id">{{ $user->id }}</td>
            <td class="user-name">{{ $user->nom }}</td>
            @if($user->getRoleNames()->first() == "Admin")
                <td>Administrateur</td>
            @else
                <td>Utilisateur</td>
            @endif
            <td><a href="{{ route('admin.show-user', $user->id) }}"><button class="btn-ajouter">Mettre à jour</button></a></td>
        </tr>
        @empty
        <p>Aucun utilisateur</p>
        @endforelse
    </tbody>
</table>
{{ $users->links() }}
