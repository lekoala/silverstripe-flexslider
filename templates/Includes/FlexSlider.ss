<% if Slides %>
<div class="flexslider-container">
    <div class="flexslider">
        <ul class="slides">
            <% loop Slides %>
            $Me
            <% end_loop %>
        </ul>
    </div>
</div>
<% end_if %>