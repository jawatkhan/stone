<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                        	<h1  style="width:50%;float:left;">@yield('page_title')</h1>
                            <span  style="float:right;width: 50%; text-align: right;">
                                @include('partials.message')
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /# column -->
			<section id="main-content">
			    @yield('content')
			    <div class="row">
                    <div class="col-lg-12">
                        <div class="footer">
                            <p>2018 © Admin Board. - <a href="#">example.com</a></p>
                        </div>
                    </div>
                </div>
			</section>
		</div>
    </div>
</div>
