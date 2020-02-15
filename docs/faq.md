# Why The Design Pattern?
Pages are created using a Builder design pattern. This design pattern was chosen to separate the construction of the 
complex page objects from its representation to build pages for different purposes, e.g.
+ The DynamicBuilder renders a dynamic Page for the client.
+ The StaticBuilder renders a static Page for a WYSIWYG.
+ The SearchBuilder renders a dynamic Page with only some Modules for search indexes.

# What is the difference between LivingMarkup and ColdFusion?
## Well-Formatted
LivingMarkup is a well-formatted markup scripting language, and Coldfusion is not. In ColdFusion items like <cfelse>
in <cfif><cfelse></cfif> are not properly open or closed meaning it is not well-formatted. 
## Customizable Tags
Rather than building a 10 layer deep statement of conditions for a navbar, LivingMarkup design encourages the create of Module, such as navbar. Thus, LivingMarkup relies less on large nested objects than Coldfusion and is more easily read.

Coldfusion limits developers to a set of prebuilt tags. In LivingMarkup any tag can be used including pre-exist HTML5 tags. 
This has the added benefit of enhancing existing tags. For example, with LivingMarkup one could easily add a alt attribute set to
 decorator when missing from img elements.
 