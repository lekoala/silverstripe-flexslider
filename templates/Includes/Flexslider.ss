<% if Slides %>
<div class="container container-slides">
	<div class="flexslider">
		<ul class="slides">
			<% loop Slides %>
			$Me
			<% end_loop %>
		</ul>
	</div>
</div>
<% end_if %>