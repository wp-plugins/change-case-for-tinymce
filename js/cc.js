(function() {
	tinymce.create('tinymce.plugins.nocaps', {
        init : function(ed, url) {
            ed.addButton('nocaps', {
                title : 'Lowercase',
                image : url+'/nc.png',
                onclick : function() {
					String.prototype.lowerCase = function() {
    return this.toLowerCase();
}
            var sel = ed.dom.decode(ed.selection.getContent());
            sel = sel.lowerCase();
            ed.selection.setContent(sel);
            ed.save();
            ed.isNotDirty = true;
        }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Change Case NC Code",
				author : 'Michael Aronoff',
                authorurl : 'http://www.ciic.com',
                version : "1.7"
            };
        }
    });
	tinymce.create('tinymce.plugins.allcaps', {
        init : function(ed, url) {
            ed.addButton('allcaps', {
                title : 'Uppercase',
                image : url+'/ac.png',
                onclick : function() {
					String.prototype.upperCase = function() {
    return this.toUpperCase();
}
            var sel = ed.dom.decode(ed.selection.getContent());
            sel = sel.upperCase();
            ed.selection.setContent(sel);
            ed.save();
            ed.isNotDirty = true;
        }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Change Case AC Code",
				author : 'Michael Aronoff',
                authorurl : 'http://www.ciic.com',
                version : "1.7"
            };
        }
    });
	tinymce.create('tinymce.plugins.sentencecase', {
        init : function(ed, url) {
            ed.addButton('sentencecase', {
                title : 'Sentence Case',
                image : url+'/sc.png',
                onclick : function() {
					String.prototype.sentenceCase = function() {
    return this.toLowerCase().replace(/(^\s*\w|[\.\!\?]\s*\w)/g, function(c)
	{
		return c.toUpperCase()
	});
}
            var sel = ed.dom.decode(ed.selection.getContent());
            sel = sel.sentenceCase();
            ed.selection.setContent(sel);
            ed.save();
            ed.isNotDirty = true;
        }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Change Case Sc Code",
				author : 'Michael Aronoff',
                authorurl : 'http://www.ciic.com',
                version : "1.7"
            };
        }
    });
	tinymce.create('tinymce.plugins.titlecase', {
        init : function(ed, url) {
            ed.addButton('titlecase', {
                title : 'Title Case',
                image : url+'/tc.png',
                onclick : function() {
					String.prototype.titleCase = function() {
    return this.toLowerCase().replace(/(^|[^a-z])([a-z])/g, function(m, p1, p2)
    {
        return p1 + p2.toUpperCase();
    });
}
            var sel = ed.dom.decode(ed.selection.getContent());
            sel = sel.titleCase();
            ed.selection.setContent(sel);
            ed.save();
            ed.isNotDirty = true;
        }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
        getInfo : function() {
            return {
                longname : "Change Case TC Code",
				author : 'Michael Aronoff',
                authorurl : 'http://www.ciic.com',
                version : "1.7"
            };
        }
    });
	tinymce.PluginManager.add('nocaps', tinymce.plugins.nocaps);
	tinymce.PluginManager.add('allcaps', tinymce.plugins.allcaps);
	tinymce.PluginManager.add('sentencecase', tinymce.plugins.sentencecase);
	tinymce.PluginManager.add('titlecase', tinymce.plugins.titlecase);
})();