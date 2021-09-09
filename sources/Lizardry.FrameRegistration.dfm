object FrameRegistration: TFrameRegistration
  Left = 0
  Top = 0
  Width = 748
  Height = 527
  Font.Charset = RUSSIAN_CHARSET
  Font.Color = clWindowText
  Font.Height = -19
  Font.Name = 'Courier New'
  Font.Style = []
  ParentFont = False
  TabOrder = 0
  object Label1: TLabel
    Left = 144
    Top = 125
    Width = 55
    Height = 21
    Caption = #1051#1086#1075#1080#1085
  end
  object Label2: TLabel
    Left = 144
    Top = 187
    Width = 66
    Height = 21
    Caption = #1055#1072#1088#1086#1083#1100
  end
  object Label3: TLabel
    Left = 144
    Top = 253
    Width = 143
    Height = 21
    Caption = #1048#1084#1103' '#1087#1077#1088#1089#1086#1085#1072#1078#1072
  end
  object edUserName: TEdit
    Left = 144
    Top = 144
    Width = 177
    Height = 29
    CharCase = ecLowerCase
    MaxLength = 16
    TabOrder = 0
  end
  object edUserPass: TEdit
    Left = 144
    Top = 206
    Width = 177
    Height = 29
    CharCase = ecLowerCase
    MaxLength = 16
    PasswordChar = '*'
    TabOrder = 1
  end
  object edCharName: TEdit
    Left = 144
    Top = 272
    Width = 177
    Height = 29
    MaxLength = 16
    TabOrder = 2
  end
  object bbRegistration: TBitBtn
    Left = 144
    Top = 320
    Width = 161
    Height = 33
    Caption = #1056#1077#1075#1080#1089#1090#1088#1072#1094#1080#1103
    TabOrder = 3
    OnClick = bbRegistrationClick
  end
  object bbBack: TBitBtn
    Left = 326
    Top = 320
    Width = 75
    Height = 33
    Caption = #1053#1072#1079#1072#1076
    TabOrder = 4
    OnClick = bbBackClick
  end
end
