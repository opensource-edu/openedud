@extends("layouts.master")

@section("body")
    <section class="course-detail">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">课程</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$course->title()}}</li>
                </ol>
            </nav>

            <div class="row course-detail-information">
                <div class="col-5">
                    <img class="course-detail-cover" src="http://edu-image.nosdn.127.net/1847D39FEFDB5D31AC65736F7BE2029E.png?imageView&quality=100&thumbnail=223y124" />
                </div>
                <div class="col-7">
                    <h1>Cybersecurity for Business 专项课程</h1>
                    <p>It seems anymore that you can't listen to the news without hearing of a data breach. You may have heard it said before that there are 2 types of companies out there, the ones who have been breached and those who will be breached. Defending against attackers who want to compromise assets can seem like an arduous task, but learning how attacks work and more importantly how to defend against those attacks can be very fulfilling. This specialization is designed to introduce you to practical computer security by teaching you the fundamentals of how you use security in the business world. This course is for those who want to understand how to defend computer systems and assets from attackers and other threats. It is also for those who want to understand how threats and attacks are carried out to help better defend their systems. .</p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">介绍</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu1">目录</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu2">笔记</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            {{$course->description()}}
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            <table class="table table-borderless table-of-contents">
                                @foreach ($course->tableOfContents() as $tableOfContent)
                                    <tr class="">
                                        <td>{{$tableOfContent->title()}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div id="menu2" class="tab-pane fade">
                            <h3>Menu 2</h3>
                            <p>Some content in menu 2.</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>
@endsection