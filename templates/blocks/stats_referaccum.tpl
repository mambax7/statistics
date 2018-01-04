<table width="100%">
    <tr>
        <td width="100%">
            <table width="99%">
                <tr>
                    <th colspan="2"><{$block.counterhead}></th>
                </tr>
                <{foreach item=referhits from=$block.referhits}>
                    <tr>
                        <td width="60%">
                            <a href="http://<{$referhits.refer}>" target="_new" alt="<{$referhits.refer}>">
                                <{$referhits.refer}>
                            </a>
                        </td>
                        <td align="left">
                            <{$referhits.hits}>
                        </td>
                    </tr>
                <{/foreach}>
            </table>
        </td>
    </tr>
</table>
