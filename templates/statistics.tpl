<table width="100%">
    <tr>
        <th><{$lang_stat_heading}> - <{$lang_stat_thissite}></th>
    </tr>
    <tr>
        <td>
            <table cellspacing="0" cellpadding="2" border="0" align="center" style='border: 2px solid #2F5376;'
                   width="95%">
                <tr>
                    <th colspan="2"><{$lang_stats_yearhits}></th>
                </tr>
                <{foreach item=yearhits from=$yearhits}>
                    <tr>
                        <td><b><{$yearhits.year}></b></td>
                        <td><b><{$yearhits.hits}></b></td>
                    </tr>
                <{/foreach}>
            </table>
            <table cellspacing="0" cellpadding="2" border="0" align="center" style='border: 2px solid #2F5376;'
                   width="95%">
                <tr>
                    <th colspan="2">
                        <{$lang_stat_browser}>
                    </th>
                </tr>
                <{$lang_stat_msie}>
                <{$lang_stat_netscape}>
                <{$lang_stat_opera}>
                <{$lang_stat_kon}>
                <{$lang_stat_lynx}>
                <{$lang_stat_firefox}>
                <{$lang_stat_apple}>
                <{$lang_stat_mozilla}>
                <{$lang_stat_deepnet}>
                <{$lang_stat_avant}>
                <{$lang_stat_altavista}>
                <{$lang_stat_question}>
            </table>
            <table cellspacing="0" cellpadding="2" border="0" align="center" style='border: 2px solid #2F5376;'
                   width="95%">
                <tr>
                    <th colspan="2">
                        <{$lang_stat_opersys}>
                    </th>
                </tr>
                <{$lang_stat_windows}>
                <{$lang_stat_linux}>
                <{$lang_stat_mac}>
                <{$lang_stat_bsd}>
                <{$lang_stat_sun}>
                <{$lang_stat_irix}>
                <{$lang_stat_be}>
                <{$lang_stat_os2}>
                <{$lang_stat_aix}>
                <{$lang_stat_osquestion}>
            </table>
            <table cellspacing="0" cellpadding="2" border="0" align="center" style='border: 2px solid #2F5376;'
                   width="95%">
                <tr>
                    <th colspan="2"><{$lang_stats_byearhits}></th>
                </tr>
                <{foreach item=byearhits from=$byearhits}>
                    <tr>
                        <td><b><{$byearhits.year}></b></td>
                        <td><b><{$byearhits.hits}></b></td>
                    </tr>
                <{/foreach}>
            </table>
            <table cellspacing="0" cellpadding="2" border="0" align="center" style='border: 2px solid #2F5376;'
                   width="95%">
                <tr>
                    <th colspan="2">
                        <{$lang_stat_blockedtype}>
                    </th>
                </tr>
                <{$lang_stat_blockedbots}>
                <{$lang_stat_blockedreferers}>
            </table>
            <table cellspacing="0" cellpadding="2" border="0" align="center" style='border: 2px solid #2F5376;'
                   width="95%">
                <tr>
                    <th colspan="2">
                        <{$lang_misc_stats}>
                    </th>
                </tr>
                <tr>
                    <td>
                        <img src="assets/images/users.gif" border='0' alt="<{$lang_stats_regusers}>">
                        <{$lang_stats_regusers}>
                    </td>
                    <td>
                        <{$lang_stats_users}>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="assets/images/online.gif" border='0' alt="<{$lang_stats_usersonline}>">
                        <{$lang_stats_usersonline}>
                    </td>
                    <td>
                        <{$lang_stats_usersolcnt}>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="assets/images/authors.gif" border='0' alt="<{$lang_stats_auth}>">
                        <{$lang_stats_auth}>
                    </td>
                    <td>
                        <b><{$lang_stats_authors}></b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="assets/images/active.gif" border='0' alt="<{$lang_stats_ausers}>">
                        <{$lang_stats_ausers}>
                    </td>
                    <td>
                        <b><{$lang_stats_activeusers}></b>
                    </td>
                </tr>

                <{if $news_active == true }>
                    <tr>
                        <td>
                            <img src="assets/images/news.gif" border='0' alt="<{$lang_stats_storiespublished}>">
                            <{$lang_stats_storiespublished}>
                        </td>
                        <td>
                            <b><{$lang_stats_stories}></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="assets/images/waiting.gif" border='0' alt="<{$lang_stats_waitingstories}>">
                            <{$lang_stats_waitingstories}>
                        </td>
                        <td>
                            <b><{$lang_stats_waiting}></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="assets/images/topics.gif" border='0' alt="<{$lang_stats_topics}>">
                            <{$lang_stats_topics}>
                        </td>
                        <td>
                            <b><{$lang_stats_topicscnt}></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="assets/images/comments.gif" border='0' alt="<{$lang_stats_commentsposted}>">
                            <{$lang_stats_commentsposted}>
                        </td>
                        <td>
                            <b><{$lang_stats_comments}></b>
                        </td>
                    </tr>
                <{/if}>

                <{if $amsnews_active == true }>
                    <tr>
                        <td>
                            <img src="assets/images/news.gif" border='0' alt="<{$lang_stats_amsstoriespublished}>">
                            <{$lang_stats_amsstoriespublished}>
                        </td>
                        <td>
                            <b><{$lang_stats_amsstories}></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="assets/images/waiting.gif" border='0' alt="<{$lang_stats_amswaitingstories}>">
                            <{$lang_stats_amswaitingstories}>
                        </td>
                        <td>
                            <b><{$lang_stats_amswaiting}></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="assets/images/topics.gif" border='0' alt="<{$lang_stats_amstopics}>">
                            <{$lang_stats_amstopics}>
                        </td>
                        <td>
                            <b><{$lang_stats_amstopicscnt}></b>
                        </td>
                    </tr>
                <{/if}>

                <{if $sections_active == true}>
                    <tr>
                        <td>
                            <img src="assets/images/sections.gif" border="0" alt="<{$lang_stat_section}>">
                            <{$lang_stat_section}>
                        </td>
                        <td>
                            <b><{$lang_stat_sectioncnt}></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="assets/images/articles.gif" border="0" alt="<{$lang_stat_article}>">
                            <{$lang_stat_article}>
                        </td>
                        <td>
                            <b><{$lang_stat_articlecnt}></b>
                        </td>
                    </tr>
                <{/if}>

                <{if $links_active == true}>
                    <tr>
                        <td>
                            <img src="assets/images/link.png" border="0" alt="<{$lang_stats_links}>">
                            <{$lang_stats_links}>
                        </td>
                        <td>
                            <b><{$lang_stats_linkscnt}></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="assets/images/sections.gif" border='0' alt="<{$lang_stats_linkcat}>">
                            <{$lang_stats_linkcat}>
                        </td>
                        <td>
                            <b><{$lang_stats_linkcatcnt}></b>
                        </td>
                    </tr>
                <{/if}>

                <{if $xoopsgallery_active == true}>
                    <tr>
                        <td>
                            <img src="assets/images/xoopsgallery.png" border="0" alt="<{$lang_stats_gimages}>">
                            <{$lang_stats_gimages}>
                        </td>
                        <td>
                            <b><{$lang_stats_gimagescnt}></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="assets/images/xoopsgallery.png" border='0' alt="<{$lang_stats_galbums}>">
                            <{$lang_stats_galbums}>
                        </td>
                        <td>
                            <b><{$lang_stats_galbumscnt}></b>
                        </td>
                    </tr>
                <{/if}>

                <{if $tinycontent_active == true}>
                    <tr>
                        <td>
                            <img src="assets/images/content.gif" border="0" alt="<{$lang_stats_tinycontent}>">
                            <{$lang_stats_tinycontent}>
                        </td>
                        <td>
                            <b><{$lang_stats_tccnt}></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="assets/images/content.gif" border='0' alt="<{$lang_stats_tcvisible}>">
                            <{$lang_stats_tcvisible}>
                        </td>
                        <td>
                            <b><{$lang_stats_tcvcnt}></b>
                        </td>
                    </tr>
                <{/if}>

                <{if $dl_active == true}>
                    <tr>
                        <td>
                            <img src="assets/images/dlcat.gif" border="0" alt="<{$lang_stats_dlcat}>">
                            <{$lang_stats_dlcat}>
                        </td>
                        <td>
                            <b><{$lang_stats_dlcatcnt}></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="assets/images/dlfiles.gif" border='0' alt="<{$lang_stats_dlfiles}>">
                            <{$lang_stats_dlfiles}>
                        </td>
                        <td>
                            <b><{$lang_stats_dlfilescnt}></b>
                        </td>
                    </tr>
                <{/if}>

                <{if $wfdl_active == true}>
                    <tr>
                        <td>
                            <img src="assets/images/dlcat.gif" border="0" alt="<{$lang_stats_wfdlcat}>">
                            <{$lang_stats_wfdlcat}>
                        </td>
                        <td>
                            <b><{$lang_stats_wfdlcatcnt}></b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="assets/images/dlfiles.gif" border='0' alt="<{$lang_stats_wfdlfiles}>">
                            <{$lang_stats_wfdlfiles}>
                        </td>
                        <td>
                            <b><{$lang_stats_wfdlfilescnt}></b>
                        </td>
                    </tr>
                <{/if}>

                <tr>
                    <td>
                        <img src="assets/images/xoops.gif" border='0' alt="<{$xoops_version}>">
                        <{$lang_xoops_version}>
                    </td>
                    <td>
                        <b><{$xoops_version}></b>
                    </td>
                </tr>
            </table>
            <table cellspacing="0" cellpadding="2" border="0" align="center" style='border: 2px solid #2F5376;'
                   width="95%">
                <tr>
                    <th colspan="2">
                        <{$lang_stat_uahead}>
                    </th>
                </tr>
                <tr>
                    <td><b><{$lang_stat_useragent}></b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
