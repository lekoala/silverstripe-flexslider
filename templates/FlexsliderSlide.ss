<li class="flexslider-slide $SlideClass">
	<% if HasContent %>
	<div class="flexslider-content">
		<% if Title %>
		<div class="flexslider-title">$Title</div>
		<% end_if %>
		<% if Description %>
		<div class="flexslider-description">$Description</div>
		<% end_if %>
	</div>
	<% end_if %>
	<% if Image %>
	<div class="flexslider-image">
		$ResizedImage
	</div>
	<% end_if %>
</li>