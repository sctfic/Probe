	<footer>
		© <?=date('Y')?> – 
		<span 
			xmlns:dct="http://purl.org/dc/terms/"
			property="dct:title"
		>Probe</span>
		<?php
			echo sprintf(
				i18n('project.license.by%s,%s,%s')
				, i18n('project.team-name')
				, i18n('project.license.logo-alt')
				, i18n('project.license.logo-title')
			);
		?>
.
	</footer>

</body>
</html>