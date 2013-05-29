<script type="text/javascript">
	var VK_width = {$vkwidth};
	var VK_height = {$vkheight};
	var VK_id = {$vkid};
</script>
{literal}
{url type="js" file="//vk.com/js/api/openapi.js?84"}
<div id="vk_groups"></div>
<script type="text/javascript">
	VK.Widgets.Group("vk_groups", {mode: 0, width: VK_width, height: VK_height}, VK_id);
</script>
{/literal}