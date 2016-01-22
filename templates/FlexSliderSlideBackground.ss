<li class="flexslider-slide $SlideClass" style="background-image:url($ResizedImage.URL);">
	<% if HasContent %>
	<div class="flexslider-window">
		<% if Title %>
		<div class="flexslider-title">$Title</div>
		<% end_if %>
		<% if Content %>
		<div class="flexslider-content">$Content</div>
		<% end_if %>
	</div>
	<% end_if %>
</li>