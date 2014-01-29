<?php
Class User extends DB
{
	function User($userId) {
	}
	function isVisitor() {
	}
	function isFreeMember() {
		return 1;
	}
	function getMemberPlan() {
	}
	function canSeeFullProfiles() {
		return isVisitor() ? false : true;
	}
	function canBlockMembers() {
		if (isFreeMember()) return false;

		// All registered users can block a limited number of profiles
		return true;
	}
	function getNumberOfMembersBlockable() {
		if (isVisitor()) return 0;

		return isFreeMember() ? 1 : 1000;
	}

	function canViewPhotos() {
		return isVisitor() ? false : true;
	}
	function getNumberOfPhotosViewable() {
		if (isVisitor()) return 0;
		return isFreeMember() ? 1 : 10;
	}
	
	function canGenerateHoroscope() {
		return isVisitor() ? false : true;
	}
	function canViewHoroscope() {
		return isVisitor() | isFreeMember() ? false : true;
	}
	function canShortlistMembers() {
		return isVisitor() ? false : true;
	}
	function getNumberOfMembersShortlistable() {
		if (isVisitor()) return 0;
		return isFreeMember() ? 3 : 1000;
	}
	function canViewPhone() {
		return isVisitor() || isFreeMember() ? false : true;
	}
	function canViewEmail() {
		return isVisitor() || isFreeMember() ? false : true;
	}
	function canParticipateInVMMeet() {
		return isVisitor() || isFreeMember() ? false : true;
	}
	function canSeeContactInfo() {
		return isVisitor() || isFreeMember() ? false : true;
	}
	function canContactMembers() {
		return isVisitor() ? false : true;
	}
	function getNumberOfMembersContactable() {
	}
	function canSendInterest() {
		return isVisitor() ? false : true;
	}
	function canSendMessage() {
		return isVisitor() || isFreeMember() ? false : true;
	}
	function canProtectHoroscope() {
		return isVisitor() || isFreeMember() ? false : true;
	}
	function canProtectPhoto() {
		return isVisitor() || isFreeMember() ? false : true;
	}
	function canProtectPhone() {
		return isVisitor() || isFreeMember() ? false : true;
	}
}
?>
