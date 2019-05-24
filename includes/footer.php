<div class="modal fade" id="boxSearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel">Tìm kiếm</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo $_DOMAIN; ?>" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="s" placeholder="Bạn muốn tìm gì?">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>