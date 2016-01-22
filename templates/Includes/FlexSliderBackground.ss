<% if Slides %>
<div class="flexslider-container flexslider-fullscreen">
    <div class="flexslider">
        <ul class="slides">
            <% loop Slides %>
            $MeBackground
            <% end_loop %>
        </ul>
    </div>
</div>
<% end_if %>