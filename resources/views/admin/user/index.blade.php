@extends('layouts.admin')
@section('style')
@stop
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         <b>Users</b> &nbsp; <a href="{{route('admin.users.create')}}" class="bg-primary text-white text-decoration-none" style="padding:8px 12px;margin-left:15px"><i class="fa fa-plus editable" style="font-size:15px;">&nbsp;ADD</i></a>
      </h1>
      <ol class="breadcrumb">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Users</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <div class="col-md-12">
            <div class="box">
               <div class="box-header">
                  @if (session('success'))
                  <div class="alert pl-3 pt-2 pb-2" style="background-color:green;color:#fff;">
                     {{ session('success') }}
                  </div>
                  @endif

                  @if (session('error'))
                  <div class="alert pl-3 pt-2 pb-2" style="background-color:red;color:#fff;">
                     {{ session('error') }}
                  </div>
                  @endif
               </div>
               @if(count($users)>0)
               <!-- /.box-header -->
               <div class="box-body" style="overflow-x:auto;margin-top:15px">

                  <table id="usersTable" class="table table-bordered table-striped">
                     <thead class="bg-primary">
                        <tr>
                           <th>Action</th>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Username</th>
                           <th>Active/De-active</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($users as $user)
                        <td>
                           <a href="{{route('admin.users.edit', $user->id)}}"><i class="fa fa-edit" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);padding:8px;"></i></a>
                           @if($user->role != 'admin')
                           <a href="{{route('admin.users.destroy', $user->id)}}" onclick="return confirm('Sure ! You want to delete reocrd ?');"><i class="fa fa-trash" style="font-size:15px;background-color:rgba(255, 255, 255, 0.25);color:red;padding:8px;"></i></a>
                           @endif
                        </td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->username}}</td>
                        <td>
                           @if($user->role != 'admin')
                           @if($user->is_active == 1)
                           <a href="/admin/users/active/{{$user->id}}" class="btn btn-success">Active</a>
                           @else
                           <a href="/admin/users/active/{{$user->id}}" class="btn btn-danger">De-active</a>
                           @endif
                           @endif
                        </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>

               </div>
               <!-- /.box-body -->
               @else
               <center>
                  <h1>No Record found</h1>
               </center>
               @endif
            </div>
            <!-- /.box -->
         </div>
         <!-- /.col -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
@endsection

@section('script')
<script>
   $(document).ready(function() {
      $("#usersTable").DataTable();
   });
</script>
@endsection