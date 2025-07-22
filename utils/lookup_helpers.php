<?php
function getLookupValue($conn, $lookUpId) {
    return fetchSingleColumn(
        $conn,
        "SELECT LookUpTypeValue FROM lookup WHERE LookUpId = ?",
        "s",
        $lookUpId);
}

function getLookup($conn, $lookUpId) {
    return fetchSingleColumn(
        $conn,
        "SELECT LookUpTypeId FROM lookup WHERE LookUpId = ?",
        "s",
        $lookUpId
    );
}



function getLookupId($conn, $lookUpTypeName, $LookUpTypeId) {
    $lookUpId = fetchSingleColumn(
        $conn, 
        "SELECT LookUpId FROM lookup WHERE lookUpTypeName = ? AND LookUpTypeId = ?", 
        "ss", 
        $lookUpTypeName, 
        $LookUpTypeId
    );
    return $lookUpId;
}
function fetchSingleColumn($conn, $query, $type, ...$values) {
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        return null;
    }

    $stmt->bind_param($type, ...$values);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();

    return $result;
}
?>
