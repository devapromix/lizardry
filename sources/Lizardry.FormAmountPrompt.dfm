object FormAmountPrompt: TFormAmountPrompt
  Left = 0
  Top = 0
  BorderIcons = [biSystemMenu]
  BorderStyle = bsSingle
  Caption = 'Lizardry'
  ClientHeight = 258
  ClientWidth = 666
  Color = clBtnFace
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  OldCreateOrder = False
  PixelsPerInch = 96
  TextHeight = 21
  object bbOK: TSpeedButton
    Left = 152
    Top = 200
    Width = 161
    Height = 33
    OnClick = bbOKClick
  end
  object bbCancel: TSpeedButton
    Left = 368
    Top = 200
    Width = 161
    Height = 33
    Caption = #1054#1090#1084#1077#1085#1072
    OnClick = bbCancelClick
  end
  object Label1: TLabel
    Left = 176
    Top = 152
    Width = 121
    Height = 21
    Caption = #1050#1086#1083#1080#1095#1077#1089#1090#1074#1086':'
  end
  object sbMinus: TSpeedButton
    Left = 328
    Top = 149
    Width = 34
    Height = 29
    Caption = '<<'
    OnClick = sbMinusClick
  end
  object sbPlus: TSpeedButton
    Left = 415
    Top = 149
    Width = 34
    Height = 29
    Caption = '>>'
    OnClick = sbPlusClick
  end
  object lbMessage: TPanel
    Left = 0
    Top = 0
    Width = 666
    Height = 121
    Align = alTop
    Caption = 'lbMessage'
    TabOrder = 0
  end
  object AmountEdit: TEdit
    Left = 368
    Top = 149
    Width = 41
    Height = 29
    Alignment = taCenter
    ReadOnly = True
    TabOrder = 1
    Text = '1'
  end
end
