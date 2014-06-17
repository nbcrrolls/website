#
# This file is execfile()d with the current directory set to its containing dir.

import sys, os

extensions = ['sphinx.ext.autodoc', 'sphinx.ext.doctest', 'sphinx.ext.pngmath', 'sphinx.ext.mathjax', 'sphinx.ext.ifconfig', 'sphinx.ext.viewcode']

templates_path = ['_templates']
source_suffix = '.rst'

master_doc = 'index'

project = u'Projects listing'
copyright = u'2014 University of California'
version = ''
release = ''
exclude_patterns = ['_build', 'save']

pygments_style = 'sphinx'

html_theme = 'default'
html_title = project
html_static_path = ['_static']
html_show_sourcelink = False
html_add_permalinks = ''

#html_sidebars = {'index': ['globaltoc.html', 'searchbox.html', 'localtoc.html']}
#html_sidebars = {}
#htmlhelp_basename = 'projectsdoc'


