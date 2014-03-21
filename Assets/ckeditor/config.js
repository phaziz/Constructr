CKEDITOR.editorConfig = function( config )
    {
    	config.toolbarGroups =
    	[
    		{name:'clipboard'},
    		{name:'undo'},
    		{name:'editing'},
            {name:'find'},
            {name:'selection'},
            {name:'spellchecker'},
    		{name:'links'},
    		{name:'insert'},
    		{name:'forms'},
    		{name:'tools'},
    		{name:'mode'},
    		{name:'doctools'},
    		{name:'document'},
    		{name:'others'},
    		{name:'basicstyles'},
    		{name:'cleanup'},
    		{name:'paragraph'},
            {name:'list'},
            {name:'indent'},
            {name:'blocks'},
            {name:'align'},
            {name:'bidi'},
    		{name:'styles'},
    		{name:'colors'},
    		{name:'about'}
    	];
    	config.removeButtons = '';
    	config.format_tags = 'div,p;h1;h2;h3;pre';
    	config.removeDialogTabs = '';
    };