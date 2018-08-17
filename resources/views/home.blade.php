@extends("layouts.master")
@section("body")
<section>
    <div class="container">

        <div class="row">
            <div class="col">
                <h2>最新课程</h2>
            </div>
        </div>
        <div class="row justify-content-around">



            @for ($i = 0; $i < 10; $i++)
            <div class="col-2 home-course-list-item ">
                <dl>
                    <dt><img src="http://edu-image.nosdn.127.net/1847D39FEFDB5D31AC65736F7BE2029E.png?imageView&quality=100&thumbnail=223y124" /></dt>
                    <dd>
                        <h3>Python应用基础</h3>
                        <span>Guido van Rossum</span>
                        <p>Guido van Rossum is a Dutch programmer best known as the author of the Python programming language</p>
                    </dd>
                </dl>
            </div>
            @endfor
        </div>
    </div>
</section>
@endsection
