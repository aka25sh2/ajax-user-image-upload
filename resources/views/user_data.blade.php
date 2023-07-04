<table class="table">
    <thead>
      <tr>
        <th>Sno</th>
        <th>Profile</th>
        <th>Role</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
      </tr>
    </thead>
    <tbody>
      @foreach($user as $key=>$value)
      <tr>
        <td>{{$key+1}}</td>
        <td><img src="{{asset('images/'.$value->profile)}}"  style="width: 100px;height: 100px;"></td>
        <td>{{$value['get_role']->name}}</td>
        <td>{{$value->name}}</td>
        <td>{{$value->email}}</td>
        <td>{{$value->phone}}</td>
      </tr>
      @endforeach
    </tbody>
</table>