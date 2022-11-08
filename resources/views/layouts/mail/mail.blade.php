<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
</head>
<body>
	<table border=1px" style="border-collapse: collapse; margin: auto; margin-bottom: 15px;" width="80%" >
		<tr>
			<td  style="border:0px;" width="80%">
				<img src="{{url('public/app/media/img/logos/logo-big.png')}}" width="150">
			</td>
			<td class="tdtext"  style="border:0px;">
				@yield('headercontent')
			</td>
		</tr>
	</table>
	
		@yield('content')
	<table border=1px" style="border-collapse: collapse; margin:auto; margin-top: 15px;" width="80%" >
		<tr>
			<td  style="border:0px;" width="80%">
				<img src="{{url('public/app/media/img/logos/logo-big.png')}}" width="150">
			</td>
			<td class="tdtext"  style="border:0px;text-align: right;
    padding-right: 14px;">
                       <p style="margin-top:50px;">
                               <label style="color:black;text-decoration:none;font-size: 10px;">&copy; {{date('Y')}} Mr. Who.</label>
                       </p>
			</td>
		</tr>
	</table>	
</body>
</html>