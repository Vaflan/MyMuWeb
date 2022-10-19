<?php if (empty($_SESSION['admin']['level'])) {
    die('<u style="color:red">/!\</u> Access Denied!');
} ?>
    <fieldset class="content">
        <legend>Find Ip</legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center">
                    <form action="" method="post" name="with_ip">
                        <input type="hidden" name="search_entity" value="ip">
                        <table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
                            <tr>
                                <td width="42%" align="right">IP Address</td>
                                <td><input type="text" name="search_value" size="17" maxlength="15"></td>
                            </tr>
                            <tr>
                                <td align="right">Search type</td>
                                <td>
                                    <label>
                                        <input type="radio" name="search_type" value="1" checked>
                                        <span class="normal_text">Partial Match</span>
                                    </label>
                                    <br>
                                    <label>
                                        <input type="radio" name="search_type" value="0">
                                        <span class="normal_text">Exact Match</span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="submit" value="Find">
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
                <td align="center">
                    <form action="" method="post" name="with_acc">
                        <input type="hidden" name="search_entity" value="account">
                        <table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
                            <tr>
                                <td width="42%" align="right">Account</td>
                                <td><input type="text" name="search_value" size="17" maxlength="10"></td>
                            </tr>
                            <tr>
                                <td align="right">Search type</td>
                                <td>
                                    <label>
                                        <input type="radio" name="search_type" value="1" checked>
                                        <span class="normal_text">Partial Match</span>
                                    </label>
                                    <br>
                                    <label>
                                        <input type="radio" name="search_type" value="0">
                                        <span class="normal_text">Exact Match</span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="submit" value="Find">
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
                <td align="center">
                    <form action="" method="post" name="with_char">
                        <input type="hidden" name="search_entity" value="character">
                        <table width="100%" border="0" cellspacing="4" cellpadding="0" align="center">
                            <tr>
                                <td width="42%" align="right">Character</td>
                                <td><input type="text" name="search_value" size="17" maxlength="10"></td>
                            </tr>
                            <tr>
                                <td align="right">Search type</td>
                                <td>
                                    <label>
                                        <input type="radio" name="search_type" value="1" checked>
                                        <span class="normal_text">Partial Match</span>
                                    </label>
                                    <br>
                                    <label>
                                        <input type="radio" name="search_type" value="0">
                                        <span class="normal_text">Exact Match</span>
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="submit" value="Find">
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>
    </fieldset>

<?php if (isset($_POST['search_entity'], $_POST['search_value'])) : ?>
    <fieldset class="content">
        <legend>Search Character IP Results</legend>

        <table border="0" cellpadding="0" cellspacing="1" width="100%" align="center" class="sort-table">
            <thead>
            <tr>
                <td align="center">#</td>
                <td>Character</td>
                <td>Account</td>
                <td>IP</td>
                <td>Date Connect</td>
                <td align="center">Status</td>
            </tr>
            </thead>
            <?php
            $searchValue = clean_var(stripslashes($_POST['search_value']));
            $searchEntity = $_POST['search_entity'];
            $searchType = $_POST['search_type'];

            $queryBuildWhere = !empty($searchType)
                ? "LIKE '%{$searchValue}%'"
                : "= '{$searchValue}'";

            switch ($searchEntity) {
                case 'ip':
                    $query = "SELECT memb___id,ip,CONNECTTM,ConnectStat FROM dbo.MEMB_STAT WHERE ip {$queryBuildWhere}";
                    break;
                case 'account':
                    $query = "SELECT memb___id FROM dbo.MEMB_INFO WHERE memb___id {$queryBuildWhere}";
                    break;
                case 'character':
                    $query = "SELECT accountid,name FROM dbo.Character WHERE name {$queryBuildWhere}";
                    break;
            }
            $result = mssql_query($query);

            $rank = 1;
            while ($row = mssql_fetch_row($result)) {
                if ($searchEntity === 'ip') {
                    $get_ip_row = array($row[1], $row[2], $row[3]);
                } else {
                    $get_ip_result = mssql_query("SELECT ip,CONNECTTM,ConnectStat FROM dbo.MEMB_STAT WHERE memb___id='$row[0]'");
                    $get_ip_row = mssql_fetch_row($get_ip_result);
                }

                if ($searchEntity === 'character') {
                    $get_char_row = array($row[1]);
                } else {
                    $get_char_result = mssql_query("SELECT GameIDC FROM dbo.AccountCharacter WHERE Id='$row[0]'");
                    $get_char_row = mssql_fetch_row($get_char_result);
                }

                if ($get_ip_row[0] !== null && $get_char_row[0] === null) {
                    $get_char_row[0] = '<span style="background:red;color:white;border:1px solid black;">Error #121</span>';
                }

                if ($get_ip_row[0] === null) {
                    $get_ip_row[0] = '<span style="background:yellow;color:black;border:1px solid black;">Error #120</span>';
                }

                $get_ip_row[2] = ($get_ip_row[2] == 1)
                    ? '<img src="../images/online.gif" alt="status">'
                    : '<img src="../images/offline.gif" alt="status">';
                ?>
                <tr>
                    <td align="center"><?php echo $rank++; ?>.</td>
                    <td><?php echo $get_char_row[0]; ?></td>
                    <td><a href=?op=acc&acc=<?php echo $row[0]; ?>><?php echo $row[0]; ?></a></td>
                    <td><?php echo $get_ip_row[0]; ?></td>
                    <td><?php echo time_format($get_ip_row[1]); ?></td>
                    <td align="center"><?php echo $get_ip_row[2]; ?></td>
                </tr>
            <?php } ?>
        </table>

    </fieldset>
<?php endif; ?>