<!doctype html>


<html lang="en" class="no-js">

<!-- Mirrored from nunforest.com/minberi-mag/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Dec 2019 05:41:49 GMT -->
<head>
	@include('frontend.header.head')
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic%7CRoboto+Slab:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic" rel="stylesheet">

	@include('frontend.css.index')
    @yield('custom css')
</head>
<body>

	<!-- Container -->
	<div id="container">
		<!-- Header
		    ================================================== -->
		<header class="clearfix">

			@include('frontend.header.top_line')

			@include('frontend.header.banner')

			@include('frontend.header.navbar')
		</header>
		<!-- End Header -->

		@yield('content')

		@include('frontend.footer.index')

	</div>
	<!-- End Container -->

	@include('frontend.js.index')
	@yield('custom js')
</body>

<!-- Mirrored from nunforest.com/minberi-mag/ by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 03 Dec 2019 05:43:19 GMT -->
</html>
