@extends('layouts.admin')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header" style="display: flex; align-items: center;">
      <a href="{{ URL::to('/admin/users') }}"><i class="fa fa-arrow-circle-left" style="font-size:35px;color:red"></i></a>
      <h1 style="margin-left: 10px;">
         Add user
      </h1>
      <ol class=" breadcrumb" style="margin-left: auto; display: flex; align-items: center;">
         <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
         <li class="active">Add user</li>
      </ol>
   </section>
   <!-- Main content -->
   <section class="content">
      <div class="row">
         <!-- right column -->
         <div class="col-12">
            <!-- Horizontal Form -->
            <div class="box box-info">
               <div class="box-header with-border">
                  @if (session('error'))
                  <div class="alert pl-3 pt-2 pb-2" style="background-color:red;color:#fff;">
                     {{ session('error') }}
                  </div>
                  @endif
               </div>
               {!! Form::open(['method'=>'POST', 'action'=> 'AdminUsersController@store','files'=>true,'class'=>'form-horizontal', 'name'=>'adduserform']) !!}
               @csrf
               <div class="box-body">
                  <div class="form-group">
                     <label for="role" class="col-sm-2 control-label">User for hotel (Role)</label>
                     <div class="col-sm-4">
                        <select name="role" id="role" class="custom-select form-control form-control-rounded" required>
                           <option value="">Select hotel</option>
                           @foreach($hotels as $hotel)
                           <option value="{{$hotel->hotel_name}}">{{$hotel->hotel_name}}</option>
                           @endforeach
                        </select>
                        @if($errors->has('role'))
                        <div class="error text-danger">{{ $errors->first('role') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="name" class="col-sm-2 control-label">Name</label>
                     <div class="col-sm-4">
                        <input type="text" name="name" id="name" class="form-control border border-dark mb-2" placeholder="Enter name" required>
                        @if($errors->has('name'))
                        <div class="error text-danger">{{ $errors->first('name') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="email" class="col-sm-2 control-label">Email</label>
                     <div class="col-sm-4">
                        <input type="email" name="email" id="email" class="form-control border border-dark mb-2" placeholder="Enter email" required>
                        @if($errors->has('email'))
                        <div class="error text-danger">{{ $errors->first('email') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="username" class="col-sm-2 control-label">username</label>
                     <div class="col-sm-4">
                        <input type="text" name="username" id="username" class="form-control border border-dark mb-2" placeholder="Enter username" required>
                        @if($errors->has('username'))
                        <div class="error text-danger">{{ $errors->first('username') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="password" class="col-sm-2 control-label">Password</label>
                     <div class="col-sm-4">
                        <input type="text" name="password" id="password" class="form-control border border-dark mb-2" placeholder="Enter password" required>
                        @if($errors->has('password'))
                        <div class="error text-danger">{{ $errors->first('password') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="is_active" class="col-sm-2 control-label">Active</label>
                     <div class="col-sm-4">
                        <select name="is_active" id="is_active" class="custom-select form-control form-control-rounded" required>
                           <option value="1">Active</option>
                           <option value="0">De-Active</option>
                        </select>
                        @if($errors->has('is_active'))
                        <div class="error text-danger">{{ $errors->first('is_active') }}</div>
                        @endif
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-md-3 col-sm-2 control-label">
                        {!! Form::submit('Add', ['class'=>'btn btn-success text-white mt-1']) !!}
                     </div>
                  </div>
               </div>
               {!! Form::close() !!}
            </div>
            <!-- /.box -->
         </div>
         <!--/.col (right) -->
      </div>
      <!-- /.row -->
   </section>
   <!-- /.content -->
</div>
@endsection

@section('script')
<script>
   $(function() {
      $("form[name='adduserform']").validate({
         rules: {
            name: {
               required: true,
            },
            email: {
               required: true,
            },
            username: {
               required: true,
            },
            role: {
               required: true,
            },
            password: {
               required: true,
            }
         },
         submitHandler: function(form) {
            form.submit();
         }
      });
   });
</script>
@endsection