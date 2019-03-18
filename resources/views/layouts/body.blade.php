<div class="content-wrap">
    <div class="main">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 p-r-0 title-margin-right">
                    <div class="page-header">
                        <div class="page-title">
                            <div class="row">
                                <div class="col-md-6">
                                    <h1>@yield('page_title')</h1>
                                </div>
                                <div class="col-md-6">
                                    @yield('right-button')
                                    @include('partials.message')
                                </div>
                            </div>
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
                            <p>created @ - <a href="#">urbanit.com.bd</a></p>
                        </div>
                    </div>
                </div>
			</section>
		</div>
    </div>
</div>
