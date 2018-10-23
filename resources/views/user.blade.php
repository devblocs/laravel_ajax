@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Details</div>

                <div class="card-body">
                    <form id="userdetail" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="form-group row">
                            <label for="bio" class="col-md-4 col-form-label text-md-right">{{ __('Bio') }}</label>

                            <div class="col-md-6">
                                <input id="bio" type="text" class="form-control" name="bio" value="{{ old('bio') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Select Gender') }}</label>

                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="1">
                                    <label class="form-check-label" for="male">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="2">
                                    <label class="form-check-label" for="female">
                                        Female
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="other" value="3">
                                    <label class="form-check-label" for="other">
                                        Other
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="profile_pic" class="col-md-4 col-form-label text-md-right">Profile Picture</label>
                            <div class="col-md-6">
                                <input type="file" class="form-control-file" name="profile_pic" id="profile_pic">
                            </div>
                           
                        </div>

                        <div class="form-group row">
                            <label for="skills" class="col-md-4 col-form-label text-md-right">Skills</label>
                            <div class="col-md-6">
                                <select multiple name="skills[]" class="form-control" id="skills">
                                    <option value="php">PHP</option>
                                    <option value="laravel">Laravel</option>
                                    <option value="javascript">JavaScript</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="full_time" class="col-md-4 col-form-label text-md-right">Job Type</label>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" name="job_type[]" type="checkbox" value="1" id="full_time">
                                        <label class="form-check-label" for="full_time">
                                            Full Time
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" name="job_type[]" type="checkbox" value="2" id="part_time">
                                        <label class="form-check-label" for="part_time">
                                            Part Time
                                        </label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" name="job_type[]" type="checkbox" value="3" id="freelance   ">
                                        <label class="form-check-label" for="freelance  ">
                                            Freelance
                                        </label>
                                    </div>
                
                                </div>
                            </div>

                        
                        <div class="form-group row">
                            <label for="about" class="col-md-4 col-form-label text-md-right">{{ __('About') }}</label>

                            <div class="col-md-6">
                                <textarea class="form-control" id="about" name="about" rows="3" placeholder="Something about you"></textarea>
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id="addUserDetail" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(count($userdetails) !== 0)
                <table class="table table-boderles table-responsive text-center" id="user-detail">
                    <thead>
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-center">Bio</th>
                            <th class="text-center">About</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center">skills</th>
                            <th class="text-center">Job Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userdetails as $userdetail)
                            <tr>
                                <td>{{ $userdetail->id }}</td>
                                <td>{{ $userdetail->bio }}</td>
                                <td>{{ $userdetail->about }}</td>
                                @if(is_null($userdetail->gender))
                                    <td>{{ "No Gender selected" }}</td>
                                @elseif($userdetail->gender == 1)
                                    <td>{{ "Male" }}</td>
                                @elseif($userdetail->gender == 2)
                                    <td>{{ "Female" }}</td>
                                @else
                                    <td>{{ "Other" }}</td>
                                @endif

                                <td>{{ is_null($userdetail->skills) ? "No Skills Selected" : $userdetail->skills }}</td>

                                @if(is_null($userdetail->job_type))
                                    <td>{{ "No Job Type selected" }}</td>
                                @elseif($userdetail->job_type == 1)
                                    <td>{{ "Full Time" }}</td>
                                @elseif($userdetail->job_type == 2)
                                    <td>{{ "Part Time" }}</td>
                                @else
                                    <td>{{ "Freelance" }}</td>
                                @endif

                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                {{ 'No data created!' }}
            @endif

            
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $('document').ready(function(){

            var baseurl = "{{ url('/') }}";
            $('#userdetail').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: baseurl + '/user/create',
                    method: "POST",
                    data: new FormData($('#userdetail')[0]),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data){
                        console.log(data);
                    }
                })
            });
        });
    </script>
@endsection
