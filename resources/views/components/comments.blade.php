<br><br><br>

<div class="row row_comments">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body">
                <form id="formComment">
                    <textarea name="comment" maxlength="1000" id="text_comment" class="form-control" rows="2" placeholder="Добавьте Ваш комментарий"></textarea>
                    <div class="errorComment"></div>
                    <div class="msgComment"></div>
                    <div class="mar-top clearfix">
                        <button disabled id="btn_send_comment" class="btn btn-sm btn-primary pull-right" type="submit"><i class="fa fa-pencil fa-fw"></i> Добавить</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel">
            <div class="panel-body" id="redirect_comments">
                <div class="comments"></div>
                <img class="loader loader_comment" src="{{ asset('imgs/loader.gif') }}" alt="loader">
                <div class="msgEmptyComments"></div>
                <div class="notifyComments"></div>
            </div>
        </div>
    </div>

</div>
