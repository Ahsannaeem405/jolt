<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
 
   
    @if($data['type']=='user')
    <h2>Hello there,</h2>
    your varification code is  <b> {{$data['otp']}}</b>
    @endif

</body>
</html>