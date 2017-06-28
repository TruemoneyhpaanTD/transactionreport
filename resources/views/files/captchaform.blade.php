     <div class="panel panel-primary">
        <div class="panel-heading">Google reCaptcha Validation Example</div>
          <div class="panel-body">   
             <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
                {!! Form::open(array('route' => 'google.post-recaptcha-validation','method'=>'POST','files'=>true,'id'=>'myform')) !!}
                 
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                            {!! $errors->first('name', '<p class="alert alert-danger">:message</p>') !!}
                        </div>
                    </div>
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Email:</strong>
                            {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                            {!! $errors->first('email', '<p class="alert alert-danger">:message</p>') !!}
                        </div>
                    </div>
                   <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Phone:</strong>
                            {!! Form::text('phone', null, array('placeholder' => 'Mobile No','class' => 'form-control')) !!}
                            {!! $errors->first('phone', '<p class="alert alert-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Details:</strong>
                            {!! Form::textarea('details', null, array('placeholder' => 'Details','class' => 'form-control','style'=>'height:100px')) !!}
                            {!! $errors->first('details', '<p class="alert alert-danger">:message</p>') !!}
                        </div>
                    </div>
                     <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Captcha:</strong>
                            {!! app('captcha')->display() !!}
                            {!! $errors->first('g-recaptcha-response', '<p class="alert alert-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
              
                {!! Form::close() !!}
                </div>
               </div>
            </div>
        </div>