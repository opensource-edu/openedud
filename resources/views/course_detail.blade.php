@extends("layouts.master")

@section("head")
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/clappr@latest/dist/clappr.min.js"></script>
@endsection

@section("body")
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="player"></div>
                <script>
                    var player = new Clappr.Player({
                        source: "https://ikeepon.oss-cn-hangzhou.aliyuncs.com/video/Microservices.mp4",
                        parentId: "#player",
                        width: '100%'
                    });

                    $(document.body).ready(function() {
                        $(".bd-example-modal-lg").on("hide.bs.modal", function(e) {
                            player.pause()
                        })
                    })

                </script>
            </div>
        </div>
    </div>


    <section class="course-detail">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">首页</a></li>
                    <li class="breadcrumb-item"><a href="/">课程</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$course->title()}}</li>
                </ol>
            </nav>

            <div class="row course-detail-information">
                <div class="col-5">
                    <img class="course-detail-cover" src="http://edu-image.nosdn.127.net/1847D39FEFDB5D31AC65736F7BE2029E.png?imageView&quality=100&thumbnail=223y124" />
                </div>
                <div class="col-7">
                    <h1>{{$course->title()}}</h1>
                    <p>{{$course->description()}}</p>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#home">介绍</a></li>
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu1">目录</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu2">笔记</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade">
                            {{$course->description()}}
                        </div>
                        <div id="menu1" class="tab-pane fade show active">
                            <table class="table table-borderless table-of-contents">
                                @foreach ($course->tableOfContents() as $tableOfContent)
                                    <tr class="">
                                        <td><a href="###" data-toggle="modal" data-target=".bd-example-modal-lg">{{$tableOfContent->title()}}</a></td>
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