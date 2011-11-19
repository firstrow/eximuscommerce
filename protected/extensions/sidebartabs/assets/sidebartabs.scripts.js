
	$(document).ready(function() {
		$(".SidebarTabsContent .tab").hide(); //Hide all content
		$(".SidebarTabsContent .tab:first").show(); //Show first tab content
		$(".SidebarTabsControl a:first").addClass('active');
	});

	function SidebarShowTab(id, el)
	{
		$(".SidebarTabsContent .tab").hide();
		$(".SidebarTabsControl a").removeClass('active');
		$("#" + id).show();
		$(el).addClass('active');
	}
