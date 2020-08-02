@extends('Admin.master')
@section('script')
    <script>
        $('#beginDateTime').MdPersianDateTimePicker({
            targetTextSelector:"#beginDateTime",
            enableTimePicker: true
        });
        $("#beginDateTime").inputmask("(n999|zmmm)/(0n|10|11|12|۰z|۱۰|۱۱|۱۲)/(0n|19|29|30|31|۰z|۱m|۲m|۳۰|۳۱) hm:mm:ss",{"placeholder":"_"});
        $('#endDateTime').MdPersianDateTimePicker({
            targetTextSelector:"#endDateTime",
            enableTimePicker: true
        });
        $("#endDateTime").inputmask("(n999|zmmm)/(0n|10|11|12|۰z|۱۰|۱۱|۱۲)/(0n|19|29|30|31|۰z|۱m|۲m|۳۰|۳۱) hm:mm:ss",{"placeholder":"_"});
        function sendConfirmComment(commentId){
            $.ajax({
                method : 'POST',
                data : { commentId , _token : '{{ csrf_token() }}'},
                url : '{{route('comment.status')}}',
                success : function(response){
                  $('#myTr'+commentId).remove();
                }
            })
        }
        function showReplayModal(comment){
            $('#commentText').text(comment.text);
            $('#productId').val(comment.product_id);
            $('#commentId').val(comment.id);
            $('#replayCommentModal').modal('toggle');
        }
        function sendReplayComment(){
            $.ajax({
                method : 'POST',
                data : {
                    text : $('#text').val(),
                    parent_id : $('#commentId').val() ,
                    product_id : $('#productId').val() ,
                    user_id : '{{auth()->user()->id}}' ,
                    _token : '{{ csrf_token() }}',
                    status : 1
                },
                url : '{{route('sendComment')}}',
                success : function(response){
                    $('#replayCommentModal').modal('hide');
                }
            })
        }
    </script>
@endsection
@section('content')
    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
        <div class="page-header head-section">
            <h4 class="float-right">کامنت ها</h4>
        </div>
        <div class="dropdown-divider float-right w-100 bg-dark"></div>
        <div class="float-right w-100">
            <div class="w-100" style="border-radius: 5px;border: 1px solid #aaa;background: #ccc;float: right;padding: 1% 1% 0 1%;margin-bottom: 1%">
                <form action="{{route('comments.index')}}">
                    <div class="col-md-3 float-right" style="direction: ltr">
                        <div class="input-group">
                            <div class="input-group-prepend">
                             <span class="input-group-text cursor-pointer" id="beginDateTimeButton" style="direction: rtl">
                                <i class="fa fa-calendar"></i>
                             </span>
                            </div>
                            <input autocomplete="off" class="form-control" placeholder="ازتاریخ؟" name="beginDateTime" id="beginDateTime" value="{{request('beginDateTime')}}" style="direction:ltr" />
                        </div>
                    </div>
                    <div class="col-md-3 float-right" style="direction: ltr">
                        <div class="input-group">
                            <div class="input-group-prepend">
                             <span class="input-group-text cursor-pointer" id="endDateTimeButton" style="direction: rtl">
                                <i class="fa fa-calendar"></i>
                             </span>
                            </div>
                            <input autocomplete="off" class="form-control" name="endDateTime" id="endDateTime"  placeholder="تا تاریخ؟" value="{{request('endDateTime')}}" style="direction:ltr" />
                        </div>
                    </div>
                    <div class="col-md-2 float-right" style="direction: ltr">
                        <div class="input-group">
                            <select name="status" class="form-control selectpicker">
                                <option value="">انتخاب کنید</option>
                                <option value="1" {{request('status') == 1 ? 'selected' : ''}}>تایید شده</option>
                                <option value="0" {{request('status') == 0 ? 'selected' : ''}}>تایید نشده</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group  col-md-2 col-sm-2 col-lg-2 col-xs-2 float-right">
                        <button class="btn btn-dark col-md-7 col-lg-7 col-sx-7 col-xs-7" type="submit">جستجو</button>
                    </div>
                </form>
            </div>
        </div>
        @if($comments->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 5%">ردیف</th>
                        <th style="width: 10%">کاربر</th>
                        <th style="width: 10%">محصول</th>
                        <th style="width: 50%">متن نظر</th>
                        <th style="width: 15%">تاریخ ارسال</th>
                        <th style="width: 10%">تنظیمات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comments as $comment)
                        <tr id="myTr{{$comment->id}}">
                            <td>{{$row++}}</td>
                            <td>{{$comment->user->username}}</td>
                            <td>{{$comment->product->title}}</td>
                            <td>{{$comment->text}}</td>
                            <td>{{ $comment->created_at }}</td>
                            <td>
                                <div class="btn-group btn-group-xs btn-group-xs">
                                    <button id="myButton{{$comment->id}}" type="button" onclick="sendConfirmComment({{$comment->id}})" type="submit" class="btn btn-sm {{$comment->status == 0 ? 'btn-danger' : 'btn-success'}}">
                                        @if($comment->status == 0)
                                            <i id="myIcon{{$comment->id}}" class="fa fa-exclamation-triangle"></i>
                                        @else
                                            <i id="myIcon{{$comment->id}}" class="fa fa-check-square"></i>
                                        @endif
                                    </button>
                                    @if($comment->status == 1 && $comment->parent_id == null)
                                        <button class="btn btn-sm btn-info" type="button" onclick="showReplayModal({{$comment}})"><i class="fa fa-reply"></i></button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                {!! $comments->appends(request()->all())->render() !!}
            </div>
        @else
            <div class="bg-warning p-3 float-right w-100" style="border-radius: 5px">
                <h6 class="text-danger">کامنتی یافت نشد!!!</h6>
            </div>
        @endif
    </div>
    <div class="modal fade" id="replayCommentModal" tabindex="-1" role="dialog" aria-labelledby="replayCommentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">پاسخ به کامنت</h5>
                    <button type="button" class="close mr-auto ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="commentText"></p>
                    <input type="hidden" id="commentId" value="">
                    <input type="hidden" id="productId" value="">
                    <textarea id="text" class="form-control" style="height: 70px" placeholder="پاسخ موردنظر را بنویسید"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">بستن</button>
                    <button onclick="sendReplayComment()" type="button" class="btn btn-primary btn-sm">ارسال پاسخ</button>
                </div>
            </div>
        </div>
    </div>
@endsection

