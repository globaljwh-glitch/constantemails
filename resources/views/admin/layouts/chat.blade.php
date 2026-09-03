<!--  BEGIN CHAT  -->
<div id="chat">
    <div id="chat-circle" class="btn btn-raised  d-lg-block d-none">
        <i class="flaticon-comment"></i>
    </div>
    <div class="chat-box">
        <div class="chat-box-header">
            <div class="media">
                <i class="flaticon-chat-fill-1 chat align-self-center mr-3"></i>
                <img src="{{  asset('assets/admin/assets/img/logo-3.jpg') }}" class="rounded-circle mr-2 mt-2" alt="user">
                <div class="media-body">
                    <h6 class="mt-2 mb-1">Constant Email Admin</h6>
                    <p>How May I help you ?</p>
                </div>
                <span class="chat-box-toggle mt-1"><i class="flaticon-close-fill"></i></span>
            </div>
        </div>
        <div class="chat-box-body">
            <div class="chat-box-overlay">
            </div>
            <div class="chat-logs">
            </div>
        </div>
        <div class="chat-input">
            <form>
                <input type="text" id="chat-input" placeholder="Send a message...">
                <button type="submit" class="chat-submit" id="chat-submit"><i class="flaticon-send-fill-1 chat"></i>
                </button>
            </form>
        </div>
    </div>
</div>
<!--  END CHAT  -->