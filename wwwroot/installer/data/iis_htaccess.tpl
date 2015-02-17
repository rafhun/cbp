<!-- <contrexx> -->
<!--     <core_routing> -->
             <configuration>
                 <system.webServer>
                    <rewrite>
                        <rules>

                            <!-- Resolve language specific sitemap.xml -->
                            <rule name="rule_1" stopProcessing="true">
                                <match url="^(\w+)\/sitemap.xml$" />
                                <action type="Rewrite" url="sitemap_{R:1}.xml" />
                            </rule>

                            <!-- Allow directory index files -->
                            <rule name="rule_2" stopProcessing="true">
                                <match url="." ignoreCase="false" />
                                <conditions>
                                    <add input="{REQUEST_FILENAME}/index.php" matchType="IsFile" ignoreCase="false" />
                                </conditions>
                                <action type="Rewrite" url="{URL}/index.php" appendQueryString="true" />
                            </rule>

                            <!-- Redirect all requests to non-existing files to Contrexx -->
                            <rule name="rule_3" stopProcessing="true">
                                <match url="." ignoreCase="false" />
                                <conditions>
                                <add input="{REQUEST_FILENAME}" matchType="IsFile" ignoreCase="false" negate="true" />
                                </conditions>
                                <action type="Rewrite" url="index.php?__cap={URL}" appendQueryString="true" />
                            </rule>

                            <!-- Add captured request to index files -->
                            <rule name="rule_4" stopProcessing="true">
                                <match url="^(.*)index.php" ignoreCase="false" />
                                <action type="Rewrite" url="{R:1}index.php?__cap={URL}" appendQueryString="true" />
                            </rule>

                        </rules>
                    </rewrite>
                 </system.webServer>
             </configuration>
<!--     </core_routing> -->
<!-- </contrexx> -->