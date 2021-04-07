@extends('layouts.app')

@section('title', __('施工商品一覧'))
@section('page_title', __('施工商品一覧'))

@section('content')
<form class="m-form m-form--fit m-form--label-align-right" id="del_form" action="/master/carrying_goods/delete" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type=hidden id="del_no" name="del_no" />
<div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
    <div class="m-portlet__body">
        <div class="row">
            <div class="col-md-12 m--padding-bottom-15">
                <a href="{{ url('/master/carrying_goods/edit') }}" class="btn btn-primary pull-right">
                        <span>
                            <i class="fa flaticon-add-circular-button"></i>
                            <span>&nbsp;&nbsp;施工商品追加&nbsp;&nbsp;</span>
                        </span>
                </a>
            </div>
            <div class="col-md-12">
                <table width="100%" class="table table-striped table-bordered table-advance table-hover">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>種類</td>
                            <td>商品名</td>
                            <td>価格</td>
                            <td>画像</td>
                            <td>動作</td>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($goods as $ind => $u)
                        <tr class="row-{{ (($goods->currentPage() - 1) * $per_page + $ind + 1)%2 }}" ref="{{ $u->id }}">
                            <td>{{ ($goods->currentPage() - 1) * $per_page + $ind + 1 }}</td>
                            <td>
                              @if ($u->type == 0)
                                そのた
                              @else
                                フォン
                              @endif
                          </td>
                            <td>{{ $u->name }}</td>
                            <td>{{ $u->price }}</td>
                            <td>
                                <div><img src="{{ $image_url.$u->image }}" style="height:50px"/></div>
                            </td>
                        <td>
                            <div class="p-action">
                                <a href="/master/carrying_goods/edit/{{ $u->id }}" class="btn btn-outline-primary m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-edit"></i></a>
                                <a href="#" onclick="delete_confirm('{{ $u->id }}');" class="btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only"><i class="fa fa-trash"></i></a>
                            </div>
                        </td>
                        </tr>
                    @empty
                        <tr><td colspan="100" class="no-items">検索結果がないです.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <div class="pull-right">{{ $goods->links() }}</div>
            </div>
        </div>
    </div>
</div>
</form>
@endsection

@section('script')
<script>
        function delete_confirm(del_no){

            swal({title:"Are you sure?",
                    text:"You won't be able to revert this!",
                    showCancelButton:!0,
                    confirmButtonText:"Yes, delete it!",
                    cancelButtonText:"No, cancel!",
                })
                .then(function(e){
                    if (e.value == 1)
                    {
                        $('#del_no').val(del_no);
                        $('#del_form').submit();
                    }
                })

        }
</script>
@endsection
