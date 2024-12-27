<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-7 py-4 px-4 ml-7 mt-7 rounded-md font-semibold font-poppins flex justify-center">
            <div class="flex flex-row gap-2">
                <h1 class="mobile-header text-white text-sm lg:text-md">{{ $breadcrumb->title }} <span >&gt;</span></h1>
                <h2 class="mobile-header text-white text-sm lg:text-md">{{ $breadcrumb->subtitle }}</h2>
            </div>
        </div>
    </div>
</section>

<style>
    @media (max-width: 767px) {
        .mobile-header {
            font-size: 18px; 
        }
    }
</style>
