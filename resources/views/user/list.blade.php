@foreach ($users as $user)
<tr>
    <td>{{$user->id}}</td>
    <td>{{$user->name}}</td>
    <td><input type="checkbox"></td>
</tr>
@endforeach