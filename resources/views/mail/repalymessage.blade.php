<!DOCTYPE html>
<html>
<head>
    <title>{{env('APP_NAME')}}</title>
</head>
<body>
  <div>
      <img src="{{@$data['logo']}}" alt="Logo">
  </div>
  <div style="margin-top:50px; margin-bottom: 50px;">
   <h3 style="text-align: center;"> Thank You  <b>{{$data['name']}}</b> </h3>
    <p style="margin-top:20px;">
        {!! html_entity_decode($data['repaly_message'])!!}
    </p>
  </div>
  <div style="margin-top:10px; margin-bottom: 50px; ">

    @if (isset($data['image']))
    <img src="{{@$data['image']}}" style=" height: 70%; width: 70%; align-content: center"/>
    @endif

    </div>
  <div>
    Thank You<br>
  <b>{{env('APP_NAME')}}</b>
  </div>
</body>
</html>
