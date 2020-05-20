<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ocr</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <!--CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
    <div class="top-right links">
        @auth
        <a href="{{ url('/home') }}">Home</a>
        @else
        <a href="{{ route('login') }}">Login</a>

        @if (Route::has('register'))
        <a href="{{ route('register') }}">Register</a>
        @endif
        @endauth
    </div>
    @endif


<div class="container">
    <div class="row">
        <div class="col-sm">
            <img src="{{$LicensePlate['ossUrl']}}" alt="">$LicensePlate
            <p>车牌号：{{$LicensePlate['result']['Plates'][0]['PlateNumber']}}</p>
            <p>车型：{{$LicensePlate['result']['Plates'][0]['PlateType']}}</p>
        </div>
        <div class="col-sm">
            <img class="image" src="{{$DriverLicense['ossUrl']}}" alt="">DriverLicense
            <p>驾驶证时间：{{$DriverLicense['result']['FaceResult']['StartDate']}}-{{$DriverLicense['result']['FaceResult']['EndDate']}}</p>
            <p>驾驶人地址：{{$DriverLicense['result']['FaceResult']['Address']}}</p>
            <p>驾驶证号：{{$DriverLicense['result']['FaceResult']['LicenseNumber']}}</p>
            <p>驾驶证类型：{{$DriverLicense['result']['FaceResult']['VehicleType']}}</p>
            <p>驾驶人性别：{{$DriverLicense['result']['FaceResult']['Gender']}}</p>
            <p>驾驶人名字：{{$DriverLicense['result']['FaceResult']['Name']}}</p>
        </div>
        <div class="col-sm">
            <img class="image" src="{{$DrivingLicense['ossUrl']}}" alt="">DrivingLicense
            <p>行驶证注册时间：{{$DrivingLicense['result']['FaceResult']['RegisterDate']}}</p>
            <p>行驶人地址：{{$DrivingLicense['result']['FaceResult']['Address']}}</p>
            <p>行驶证号：{{$DrivingLicense['result']['FaceResult']['PlateNumber']}}</p>
            <p>行驶证类型：{{$DrivingLicense['result']['FaceResult']['VehicleType']}}</p>
            <p>车型号：{{$DrivingLicense['result']['FaceResult']['Model']}}</p>
            <p>车主名字：{{$DrivingLicense['result']['FaceResult']['Owner']}}</p>
            <p>发动机号：{{$DrivingLicense['result']['FaceResult']['EngineNumber']}}</p>
            <p>VIN：{{$DrivingLicense['result']['FaceResult']['Vin']}}</p>
            <p>营运范围：{{$DrivingLicense['result']['FaceResult']['UseCharacter']}}</p>
        </div>
    </div>
</div>

</body>

<style>
    .image{
        width: 180px;
        height: auto;
    }
</style>
</html>
