@extends('layouts.admin')
@section('css')

@endsection

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">url列表</h3>

            <div class="panel-options">
                <a href="#" data-toggle="panel">
                    <span class="collapse-icon">&ndash;</span>
                    <span class="expand-icon">+</span>
                </a>
                <a href="#" data-toggle="remove">
                    &times;
                </a>
            </div>
        </div>

        <div class="row" style="display: none" id="success">
            <div class="col-md-12">
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">关闭</span>
                    </button>
                    <strong>成功了！</strong>你已经成功删除url
                </div>
            </div>
        </div>

        <div class="row" style="display: none" id="danger">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">×</span>
                        <span class="sr-only">关闭</span>
                    </button>
                    <strong>失败了！</strong>删除url失败
                </div>
            </div>
        </div>

        <div class="panel-body">
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    $("#example-2").dataTable({
                        dom: "t" + "<'row'<'col-xs-6'i><'col-xs-6'p>>",
                        aoColumns: [
                            {bSortable: false},
                            null,
                            null,
                        ],
                    });
                });
            </script>

            <table class="table table-bordered table-striped" id="example-2">
                <input value="" id="linkid" hidden>
                <thead>
                <tr>
                    <th>编号</th>
                    <th>公众号</th>
                    <th>链接地址</th>
                    <th>操作</th>
                </tr>
                </thead>

                <tbody class="middle-align">
                @foreach($urls as $url)
                    <tr >
                        <td>{{ $url->id }}</td>
                        <td>{{ $url->name }}</td>
                        <td>{{ $url->url  }}</td>
                        <td>
                            <a href="{{ url('admin/urledit') }}/{{ $url->id }}"
                               class="btn btn-secondary btn-sm btn-icon icon-left">
                                编辑
                            </a>

                            <a href="javascript:;" onclick="getId({{ $url->id }})"
                               class="btn btn-danger btn-sm btn-icon icon-left">
                                删除
                            </a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <button onclick="location.href='{{ url('admin/urladd') }}'" class="btn btn-info btn-single pull-right">
                添加链接
            </button>

        </div>
    </div>

@endsection
@section('js')
    {{--弹出框--}}
    <div class="modal fade" id="modal-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">删除确认</h4>
                </div>

                <div class="modal-body">
                    你确定删除吗？
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" id="modal_hide" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-info" onclick="deletepost()">确定</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function getId(id) {
            $('#linkid').val(id);
            jQuery('#modal-1').modal('show', {backdrop: 'fade'});
        }

        function deletepost() {
            id = $('#linkid').val();
            jQuery.get("{{ url('admin/urldel') }}",
                {
                    id: id,
                },
                function (data) {
                    if (data) {
                        $('#modal_hide').click();
                        jQuery('#tr_' + id).remove();
                        $("#success").show();
                    } else {
                        $('#modal_hide').click();
                        $("#danger").show();
                    }

                });
        }
    </script>

    <!-- Imported styles on this page -->
    <link rel="stylesheet" href="{{ asset('assets/js/datatables/dataTables.bootstrap.css') }}">
    <script src="{{ asset('assets/js/datatables/js/jquery.dataTables.min.js') }}"></script>
    <!-- Imported scripts on this page -->
    <script src="{{ asset('assets/js/datatables/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/yadcf/jquery.dataTables.yadcf.js') }}"></script>
    <script src="{{ asset('assets/js/datatables/tabletools/dataTables.tableTools.min.js') }}"></script>

@endsection
